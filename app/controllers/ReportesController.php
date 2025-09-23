<?php
require_once __DIR__ . '/../models/Reporte.php';
require_once __DIR__ . '/../core/Controller.php';

require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../models/InspeccionLocativa.php';

class ReportesController extends Controller {
    // Reporte predefinido: incidentes y accidentes por empleado y fecha
    public function generarEmpleado() {
    $empleados = Empleado::all();
    $inspecciones = InspeccionLocativa::all();
    $reporteEmpleado = null;
    $inspeccionSeleccionada = null;
    $empleadoId = isset($_POST['empleado_id']) ? $_POST['empleado_id'] : '';
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
    $nombre_reporte = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $fecha_actual = isset($_POST['fecha_actual']) ? $_POST['fecha_actual'] : date('Y-m-d');
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $inspeccion_locativa_id = isset($_POST['inspeccion_locativa_id_insp_loc']) ? $_POST['inspeccion_locativa_id_insp_loc'] : null;
        if ($empleadoId) {
            $empleado = Empleado::find($empleadoId);
            $db = Database::getConnection();
            $incidentes = [];
            $accidentes = [];
            // Incidentes relacionados al empleado
            $sqlInc = "SELECT i.id_incidente, i.tipo, i.fecha_hora FROM empleado e
                JOIN categoria c ON c.empleado_id_empleado = e.id_empleado
                JOIN inspeccion_locativa il ON il.categoria_id_categoria = c.id_categoria
                JOIN incidente i ON il.incidente_id_incidente = i.id_incidente
                WHERE e.id_empleado = ?";
            $paramsInc = [$empleadoId];
            if ($fecha_inicio && $fecha_fin) {
                $sqlInc .= " AND DATE(i.fecha_hora) BETWEEN ? AND ?";
                $paramsInc[] = $fecha_inicio;
                $paramsInc[] = $fecha_fin;
            } elseif ($fecha_inicio) {
                $sqlInc .= " AND DATE(i.fecha_hora) = ?";
                $paramsInc[] = $fecha_inicio;
            }
            $stmtInc = $db->prepare($sqlInc);
            $stmtInc->execute($paramsInc);
            $incidentes = $stmtInc->fetchAll(PDO::FETCH_ASSOC);
            // Accidentes relacionados al empleado
            $sqlAcc = "SELECT a.id_accidente, a.tipo, a.fecha_hora FROM empleado e
                JOIN categoria c ON c.empleado_id_empleado = e.id_empleado
                JOIN inspeccion_locativa il ON il.categoria_id_categoria = c.id_categoria
                JOIN accidente a ON il.accidente_id_accidente = a.id_accidente
                WHERE e.id_empleado = ?";
            $paramsAcc = [$empleadoId];
            if ($fecha_inicio && $fecha_fin) {
                $sqlAcc .= " AND DATE(a.fecha_hora) BETWEEN ? AND ?";
                $paramsAcc[] = $fecha_inicio;
                $paramsAcc[] = $fecha_fin;
            } elseif ($fecha_inicio) {
                $sqlAcc .= " AND DATE(a.fecha_hora) = ?";
                $paramsAcc[] = $fecha_inicio;
            }
            $stmtAcc = $db->prepare($sqlAcc);
            $stmtAcc->execute($paramsAcc);
            $accidentes = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);
            $reporteEmpleado = [
                'id_empleado' => $empleado['id_empleado'],
                'nombres' => $empleado['nombres'],
                'apellidos' => $empleado['apellidos'],
                'incidentes' => $incidentes,
                'accidentes' => $accidentes
            ];
            // Obtener datos de la inspección locativa seleccionada
            if ($inspeccion_locativa_id) {
                $inspeccionSeleccionada = InspeccionLocativa::find($inspeccion_locativa_id);
            }
            // Guardar el reporte en la base de datos
            if ($nombre_reporte) {
                Reporte::create([
                    'nombre' => $nombre_reporte,
                    'fecha_hora' => $fecha_actual,
                    'descripcion' => $descripcion,
                    'inspeccion_locativa_id_insp_loc' => $inspeccion_locativa_id
                ]);
            }
        }
        $this->view('reportes/create', [
            'empleados' => $empleados,
            'empleado' => $empleadoId,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'reporteEmpleado' => $reporteEmpleado,
            'inspecciones' => $inspecciones,
            'inspeccionSeleccionada' => $inspeccionSeleccionada
        ]);
    }
    // Mostrar selector de tabla y campos
    public function generar() {
        $db = Database::getConnection();
        $tabla = isset($_POST['tabla']) ? $_POST['tabla'] : (isset($_GET['tabla']) ? $_GET['tabla'] : '');
        $campos = [];
        $datos = [];
        if ($tabla) {
            // Obtener campos de la tabla
            $stmt = $db->query("SHOW COLUMNS FROM $tabla");
            $campos = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        if ($tabla && isset($_POST['campos']) && is_array($_POST['campos']) && count($_POST['campos']) > 0) {
            $camposSeleccionados = $_POST['campos'];
            $sql = "SELECT " . implode(", ", $camposSeleccionados) . " FROM $tabla LIMIT 100";
            $stmt = $db->query($sql);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $this->view('reportes/index', [
            'tabla' => $tabla,
            'campos' => $campos,
            'datos' => $datos,
            'camposSeleccionados' => isset($camposSeleccionados) ? $camposSeleccionados : []
        ]);
    }
    public function index() {
        $id = isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '';
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $reportes = Reporte::getFiltered($id, $nombre, $orden);
        foreach ($reportes as &$reporte) {
            // Agregar datos completos de inspección locativa relacionada
            if (!empty($reporte['inspeccion_locativa_id_insp_loc'])) {
                $reporte['inspeccion_locativa'] = InspeccionLocativa::find($reporte['inspeccion_locativa_id_insp_loc']);
            }
            // Si el nombre contiene "empleado" (puedes ajustar la lógica según tu tipo de reporte)
            if (stripos($reporte['nombre'], 'empleado') !== false && !empty($reporte['inspeccion_locativa_id_insp_loc'])) {
                $empleadoId = $reporte['inspeccion_locativa_id_insp_loc'];
                $db = Database::getConnection();
                // Incidentes relacionados al empleado
                $sqlInc = "SELECT i.id_incidente, i.tipo, i.fecha_hora FROM empleado e
                    JOIN categoria c ON c.empleado_id_empleado = e.id_empleado
                    JOIN inspeccion_locativa il ON il.categoria_id_categoria = c.id_categoria
                    JOIN incidente i ON il.incidente_id_incidente = i.id_incidente
                    WHERE e.id_empleado = ?";
                $stmtInc = $db->prepare($sqlInc);
                $stmtInc->execute([$empleadoId]);
                $reporte['incidentes'] = $stmtInc->fetchAll(PDO::FETCH_ASSOC);
                // Accidentes relacionados al empleado
                $sqlAcc = "SELECT a.id_accidente, a.tipo, a.fecha_hora FROM empleado e
                    JOIN categoria c ON c.empleado_id_empleado = e.id_empleado
                    JOIN inspeccion_locativa il ON il.categoria_id_categoria = c.id_categoria
                    JOIN accidente a ON il.accidente_id_accidente = a.id_accidente
                    WHERE e.id_empleado = ?";
                $stmtAcc = $db->prepare($sqlAcc);
                $stmtAcc->execute([$empleadoId]);
                $reporte['accidentes'] = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        $this->view('reportes/index', [
            'reportes' => $reportes,
            'filtro_id' => $id,
            'filtro_nombre' => $nombre,
            'filtro_orden' => $orden
        ]);
    }
    public function create() {
        $inspecciones = InspeccionLocativa::all();
        $this->view('reportes/create', [
            'inspecciones' => $inspecciones
        ]);
    }
    public function store() {
        $data = [
            'nombre' => $_POST['nombre']
        ];
        Reporte::create($data);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $reporte = Reporte::find($id);
        $this->view('reportes/edit', [
            'reporte' => $reporte
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre']
        ];
        Reporte::update($id, $data);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        Reporte::delete($id);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
}
