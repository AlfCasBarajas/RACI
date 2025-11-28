<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Reporte.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../models/InspeccionLocativa.php';
require_once __DIR__ . '/../models/Area.php';

class ReportesController extends Controller {
    
    // Verificar que el usuario esté logueado
    private function onlyLogged() {
        if (!isset($_SESSION['user'])) {
            header('Location: ?controller=login&action=index');
            exit;
        }
    }
    
    // Verificar que el usuario coordinador no pueda editar
    private function checkNotCoordinadorEdit() {
        $this->onlyLogged();
        if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] == 3) {
            header('Location: ?controller=reportes&action=index');
            exit;
        }
    }
    
    // Verificar que el usuario coordinador no pueda eliminar
    private function checkNotCoordinadorDelete() {
        $this->onlyLogged();
        if (isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] == 3) {
            header('Location: ?controller=reportes&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=reportes&action=index');
            exit;
        }
    }
    
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
            if (is_array($empleado)) {
                $reporteEmpleado = [
                    'id_empleado' => $empleado['id_empleado'],
                    'nombres' => $empleado['nombres'],
                    'apellidos' => $empleado['apellidos'],
                    'incidentes' => $incidentes,
                    'accidentes' => $accidentes
                ];
            } else {
                $reporteEmpleado = null;
                // Opcional: puedes agregar un mensaje de error para la vista
                $this->view('reportes/create', [
                    'error' => 'Empleado no encontrado',
                    'empleados' => $empleados,
                    'empleado' => $empleadoId,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'inspecciones' => $inspecciones,
                    'reporteEmpleado' => null,
                    'inspeccionSeleccionada' => $inspeccionSeleccionada
                ]);
                return;
            }
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
        $this->onlyLogged();
        $userRole = isset($_SESSION['user']['rol']) ? $_SESSION['user']['rol'] : null;
        $isCoordinador = ($userRole == 3);
        $isSupervisor = ($userRole == 2);
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        
        // Mostrar el menú principal de reportes
        $this->view('reportes/index', [
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->checkNotTrabajador();
        $inspecciones = InspeccionLocativa::all();
        $this->view('reportes/create', [
            'inspecciones' => $inspecciones
        ]);
    }
    public function store() {
        $this->checkNotTrabajador();
        $data = [
            'nombre' => $_POST['nombre']
        ];
        Reporte::create($data);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    public function edit() {
        $this->checkNotCoordinadorEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $reporte = Reporte::find($id);
        $this->view('reportes/edit', [
            'reporte' => $reporte
        ]);
    }
    public function update() {
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre']
        ];
        Reporte::update($id, $data);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    public function delete() {
        $this->checkNotCoordinadorDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        Reporte::delete($id);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    
    // ============ NUEVOS MÉTODOS PARA REPORTES POR SECCIÓN ============
    
    public function empleados() {
        $this->onlyLogged();
        $nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
        $rol = isset($_GET['rol']) ? trim($_GET['rol']) : '';
        $area = isset($_GET['area']) ? trim($_GET['area']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        $empleados = Empleado::getFiltered('', $nombre, $rol, $area);
        
        if ($format === 'pdf') {
            $this->generateEmpleadosPDF($empleados, $nombre, $rol, $area);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateEmpleadosExcel($empleados, $nombre, $rol, $area);
            return;
        }
        
        // Obtener áreas para el filtro
        require_once __DIR__ . '/../models/Area.php';
        $areas = Area::all();
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/empleados', [
            'empleados' => $empleados,
            'nombre' => $nombre,
            'rol' => $rol,
            'area' => $area,
            'areas' => $areas,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateEmpleadosPDF($empleados, $filtroNombre = '', $filtroRol = '', $filtroArea = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('L', 'mm', 'A4'); // Orientación horizontal para más columnas
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Empleados'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroNombre || $filtroRol || $filtroArea) {
            $pdf->SetFont('Arial', 'I', 8);
            $filtros = [];
            if ($filtroNombre) $filtros[] = 'Nombre: ' . $filtroNombre;
            if ($filtroRol) $filtros[] = 'Rol: ' . $filtroRol;
            if ($filtroArea) $filtros[] = 'Área: ' . $filtroArea;
            $pdf->Cell(0, 5, utf8_decode('Filtros aplicados - ' . implode(', ', $filtros)), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(12, 8, 'Tipo', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Nombres', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Apellidos', 1, 0, 'C');
        $pdf->Cell(18, 8, utf8_decode('Teléfono'), 1, 0, 'C');
        $pdf->Cell(18, 8, 'EPS', 1, 0, 'C');
        $pdf->Cell(18, 8, 'ARL', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Cargo', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Antig.', 1, 0, 'C');
        $pdf->Cell(18, 8, 'Rol', 1, 0, 'C');
        $pdf->Cell(20, 8, utf8_decode('Área'), 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 6);
        foreach ($empleados as $empleado) {
            $pdf->Cell(10, 8, $empleado['id_empleado'] ?? '', 1, 0, 'C');
            $pdf->Cell(12, 8, utf8_decode($empleado['tipo_doc'] ?? ''), 1, 0, 'C');
            $pdf->Cell(25, 8, utf8_decode(substr($empleado['nombres'] ?? '', 0, 12)), 1, 0, 'L');
            $pdf->Cell(25, 8, utf8_decode(substr($empleado['apellidos'] ?? '', 0, 12)), 1, 0, 'L');
            $pdf->Cell(18, 8, $empleado['telefono'] ?? '', 1, 0, 'C');
            $pdf->Cell(18, 8, utf8_decode(substr($empleado['eps'] ?? '', 0, 8)), 1, 0, 'C');
            $pdf->Cell(18, 8, utf8_decode(substr($empleado['arl'] ?? '', 0, 8)), 1, 0, 'C');
            $pdf->Cell(25, 8, utf8_decode(substr($empleado['cargo_funcion'] ?? '', 0, 12)), 1, 0, 'L');
            $pdf->Cell(15, 8, utf8_decode(substr($empleado['antig_cargo'] ?? '', 0, 6)), 1, 0, 'C');
            $pdf->Cell(18, 8, utf8_decode(substr($empleado['rol_nombre'] ?? 'Sin rol', 0, 8)), 1, 0, 'C');
            $pdf->Cell(20, 8, utf8_decode(substr($empleado['area_nombre'] ?? 'Sin área', 0, 10)), 1, 1, 'C');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_empleados/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_empleados_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=empleados&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateEmpleadosExcel($empleados, $filtroNombre = '', $filtroRol = '', $filtroArea = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Empleados');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Empleados');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroNombre || $filtroRol || $filtroArea) {
            $filtros = [];
            if ($filtroNombre) $filtros[] = 'Nombre: ' . $filtroNombre;
            if ($filtroRol) $filtros[] = 'Rol: ' . $filtroRol;
            if ($filtroArea) $filtros[] = 'Área: ' . $filtroArea;
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados - ' . implode(', ', $filtros));
            $sheet->mergeCells('A' . $currentRow . ':K' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Tipo Doc', 'Nombres', 'Apellidos', 'Teléfono', 'EPS', 'ARL', 'Cargo/Función', 'Antigüedad', 'Rol', 'Área'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, E, F, G, H, I, J, K
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':K' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de empleados
        $dataRow = $headerRow + 1;
        foreach ($empleados as $empleado) {
            $sheet->setCellValue('A' . $dataRow, $empleado['id_empleado'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $empleado['tipo_doc'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $empleado['nombres'] ?? '');
            $sheet->setCellValue('D' . $dataRow, $empleado['apellidos'] ?? '');
            $sheet->setCellValue('E' . $dataRow, $empleado['telefono'] ?? '');
            $sheet->setCellValue('F' . $dataRow, $empleado['eps'] ?? '');
            $sheet->setCellValue('G' . $dataRow, $empleado['arl'] ?? '');
            $sheet->setCellValue('H' . $dataRow, $empleado['cargo_funcion'] ?? '');
            $sheet->setCellValue('I' . $dataRow, $empleado['antig_cargo'] ?? '');
            $sheet->setCellValue('J' . $dataRow, $empleado['rol_nombre'] ?? 'Sin rol');
            $sheet->setCellValue('K' . $dataRow, $empleado['area_nombre'] ?? 'Sin área');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(20);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':K' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_empleados/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_empleados_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=empleados&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function incidentes() {
        $this->onlyLogged();
        $tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
        $area = isset($_GET['area']) ? trim($_GET['area']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        // Usar getFilteredWithArea para incluir información del área
        $incidentes = Incidente::getFilteredWithArea($tipo, $fecha_inicio, $fecha_fin, $area);
        
        if ($format === 'pdf') {
            $this->generateIncidentesPDF($incidentes, $tipo, $fecha_inicio, $fecha_fin, $area);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateIncidentesExcel($incidentes, $tipo, $fecha_inicio, $fecha_fin, $area);
            return;
        }
        
        // Obtener áreas para el filtro
        require_once __DIR__ . '/../models/Area.php';
        $areas = Area::all();
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/incidentes', [
            'incidentes' => $incidentes,
            'tipo' => $tipo,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'area' => $area,
            'areas' => $areas,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateIncidentesPDF($incidentes, $filtroTipo = '', $fechaInicio = '', $fechaFin = '', $filtroArea = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('L', 'mm', 'A4'); // Orientación horizontal para más columnas
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Incidentes'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        $filtros = [];
        if ($filtroTipo) $filtros[] = 'Tipo: ' . $filtroTipo;
        if ($fechaInicio) $filtros[] = 'Desde: ' . $fechaInicio;
        if ($fechaFin) $filtros[] = 'Hasta: ' . $fechaFin;
        if ($filtroArea) $filtros[] = 'Área: ' . $filtroArea;
        if (!empty($filtros)) {
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(0, 5, utf8_decode('Filtros aplicados - ' . implode(', ', $filtros)), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Tipo', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Fecha/Hora', 1, 0, 'C');
        $pdf->Cell(35, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(20, 8, 'Lugar', 1, 0, 'C');
        $pdf->Cell(20, 8, utf8_decode('Área'), 1, 0, 'C');
        $pdf->Cell(25, 8, 'Vinc. Laboral', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Jornada', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Turno', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Uso EPP', 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 6);
        foreach ($incidentes as $incidente) {
            $pdf->Cell(10, 8, $incidente['id_incidente'] ?? '', 1, 0, 'C');
            $pdf->Cell(25, 8, utf8_decode(substr($incidente['tipo'] ?? '', 0, 20)), 1, 0, 'L');
            $pdf->Cell(20, 8, isset($incidente['fecha_hora']) ? date('d/m/Y H:i', strtotime($incidente['fecha_hora'])) : '', 1, 0, 'C');
            $pdf->Cell(35, 8, utf8_decode(substr($incidente['descripcion'] ?? '', 0, 25) . '...'), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode(substr($incidente['lugar'] ?? '', 0, 15)), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode(substr($incidente['nombre_area'] ?? 'Sin área', 0, 15)), 1, 0, 'L');
            $pdf->Cell(25, 8, utf8_decode(substr($incidente['tipo_vinc_lab'] ?? '', 0, 18)), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode(substr($incidente['jornada_laboral'] ?? '', 0, 15)), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode(substr($incidente['turno_mom_inc'] ?? '', 0, 15)), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode(substr($incidente['uso_epp'] ?? '', 0, 15)), 1, 1, 'L');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_incidentes/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_incidentes_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=incidentes&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateIncidentesExcel($incidentes, $filtroTipo = '', $fechaInicio = '', $fechaFin = '', $filtroArea = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Incidentes');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Incidentes');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        $filtros = [];
        if ($filtroTipo) $filtros[] = 'Tipo: ' . $filtroTipo;
        if ($fechaInicio) $filtros[] = 'Desde: ' . $fechaInicio;
        if ($fechaFin) $filtros[] = 'Hasta: ' . $fechaFin;
        if ($filtroArea) $filtros[] = 'Área: ' . $filtroArea;
        if (!empty($filtros)) {
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados - ' . implode(', ', $filtros));
            $sheet->mergeCells('A' . $currentRow . ':J' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Tipo', 'Fecha y Hora', 'Descripción', 'Lugar', 'Área', 'Tipo Vinc. Laboral', 'Jornada Laboral', 'Turno/Momento', 'Uso EPP'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, E, F, G, H, I, J
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':J' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de incidentes
        $dataRow = $headerRow + 1;
        foreach ($incidentes as $incidente) {
            $sheet->setCellValue('A' . $dataRow, $incidente['id_incidente'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $incidente['tipo'] ?? '');
            $sheet->setCellValue('C' . $dataRow, isset($incidente['fecha_hora']) ? date('d/m/Y H:i', strtotime($incidente['fecha_hora'])) : '');
            $sheet->setCellValue('D' . $dataRow, $incidente['descripcion'] ?? '');
            $sheet->setCellValue('E' . $dataRow, $incidente['lugar'] ?? '');
            $sheet->setCellValue('F' . $dataRow, $incidente['nombre_area'] ?? 'Sin área asignada');
            $sheet->setCellValue('G' . $dataRow, $incidente['tipo_vinc_lab'] ?? '');
            $sheet->setCellValue('H' . $dataRow, $incidente['jornada_laboral'] ?? '');
            $sheet->setCellValue('I' . $dataRow, $incidente['turno_mom_inc'] ?? '');
            $sheet->setCellValue('J' . $dataRow, $incidente['uso_epp'] ?? '');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(15);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':J' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_incidentes/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_incidentes_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=incidentes&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function accidentes() {
        $this->onlyLogged();
        $tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
        $area = isset($_GET['area']) ? trim($_GET['area']) : '';
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        // Usar getFilteredWithArea para incluir información del área
        $accidentes = Accidente::getFilteredWithArea($tipo, $fecha_inicio, $fecha_fin, $area);
        $areas = Area::all();
        
        if ($format === 'pdf') {
            $this->generateAccidentesPDF($accidentes, $tipo, $fecha_inicio, $fecha_fin, $area);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateAccidentesExcel($accidentes, $tipo, $fecha_inicio, $fecha_fin, $area);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/accidentes', [
            'accidentes' => $accidentes,
            'areas' => $areas,
            'tipo' => $tipo,
            'area' => $area,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateAccidentesPDF($accidentes, $filtroTipo = '', $fechaInicio = '', $fechaFin = '', $area = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4'); // Orientación vertical para formato detallado
        
        foreach ($accidentes as $accidente) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            
            // Título
            $pdf->Cell(0, 10, utf8_decode('Reporte Detallado de Accidente'), 0, 1, 'C');
            $pdf->Ln(5);
            
            // ID del accidente
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 8, utf8_decode('Accidente #' . ($accidente['id_accidente'] ?? '')), 0, 1, 'C');
            $pdf->Ln(5);
            
            // Fecha de generación
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
            $pdf->Ln(10);
            
            // Filtros aplicados
            if ($filtroTipo || $area || $fechaInicio || $fechaFin) {
                $filtros = [];
                if ($filtroTipo) $filtros[] = 'Tipo: ' . $filtroTipo;
                if ($area) $filtros[] = 'Área: ' . $area;
                if ($fechaInicio) $filtros[] = 'Desde: ' . $fechaInicio;
                if ($fechaFin) $filtros[] = 'Hasta: ' . $fechaFin;
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->Cell(0, 5, utf8_decode('Filtros aplicados - ' . implode(', ', $filtros)), 0, 1, 'L');
                $pdf->Ln(5);
            }
            
            // Información básica
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, utf8_decode('INFORMACIÓN BÁSICA'), 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10);
            
            $pdf->Cell(40, 6, utf8_decode('Tipo:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['tipo'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Fecha y Hora:'), 0, 0, 'L');
            $pdf->Cell(0, 6, isset($accidente['fecha_hora']) ? date('d/m/Y H:i', strtotime($accidente['fecha_hora'])) : 'Sin especificar', 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Lugar:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['lugar'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Área:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['nombre_area'] ?? 'Sin área asignada'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Clasificación:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['clasificacion'] ?? 'Sin clasificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Estado:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['estado'] ?? 'Sin estado'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Gravedad:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['gravedad'] ?? 'Sin evaluar'), 0, 1, 'L');
            
            $pdf->Ln(5);
            
            // Información laboral
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, utf8_decode('INFORMACIÓN LABORAL'), 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10);
            
            $pdf->Cell(40, 6, utf8_decode('Vinculación:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['tipo_vinc_lab_'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Jornada:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['jornada_laboral'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Turno/Momento:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['turno_mom_acc'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Uso EPP:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['uso_epp'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Ln(5);
            
            // Información médica
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, utf8_decode('INFORMACIÓN MÉDICA'), 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10);
            
            $pdf->Cell(40, 6, utf8_decode('Tipo Lesión:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['tipo_lesion'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Parte Afectada:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['parte_cuerpo_afect'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Incapacidad:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['incapacidad_lab'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Cell(40, 6, utf8_decode('Persona Informó:'), 0, 0, 'L');
            $pdf->Cell(0, 6, utf8_decode($accidente['persona_informo'] ?? 'Sin especificar'), 0, 1, 'L');
            
            $pdf->Ln(5);
            
            // Descripciones extensas
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, utf8_decode('DESCRIPCIÓN DETALLADA'), 0, 1, 'L');
            $pdf->SetFont('Arial', '', 10);
            
            $pdf->Cell(0, 6, utf8_decode('Descripción del accidente:'), 0, 1, 'L');
            $pdf->MultiCell(0, 5, utf8_decode($accidente['descripcion'] ?? 'Sin descripción disponible'));
            $pdf->Ln(3);
            
            $pdf->Cell(0, 6, utf8_decode('Consecuencias:'), 0, 1, 'L');
            $pdf->MultiCell(0, 5, utf8_decode($accidente['consecuencias'] ?? 'Sin especificar'));
            $pdf->Ln(3);
            
            $pdf->Cell(0, 6, utf8_decode('Atención Médica Recibida:'), 0, 1, 'L');
            $pdf->MultiCell(0, 5, utf8_decode($accidente['aten_med_recibida'] ?? 'Sin especificar'));
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_accidentes/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_accidentes_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=accidentes&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateAccidentesExcel($accidentes, $filtroTipo = '', $fechaInicio = '', $fechaFin = '', $area = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Accidentes');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte Completo de Accidentes');
        $sheet->mergeCells('A1:Q1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:Q2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        $filtros = [];
        if ($filtroTipo) $filtros[] = 'Tipo: ' . $filtroTipo;
        if ($fechaInicio) $filtros[] = 'Desde: ' . $fechaInicio;
        if ($fechaFin) $filtros[] = 'Hasta: ' . $fechaFin;
        if (!empty($filtros)) {
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados - ' . implode(', ', $filtros));
            $sheet->mergeCells('A' . $currentRow . ':Q' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados - Todos los campos incluyendo área
        $headers = [
            'ID', 'Tipo', 'Fecha y Hora', 'Descripción', 'Lugar', 'Área',
            'Clasificación', 'Estado', 'Gravedad', 'Tipo Lesión', 'Parte Afectada',
            'Consecuencias', 'Vinculación Laboral', 'Jornada Laboral', 'Turno/Momento', 
            'Uso EPP', 'Incapacidad Laboral', 'Atención Médica', 'Persona Informó'
        ];
        $headerRow = $currentRow;
        
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValue($columns[$index] . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':S' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de accidentes
        $dataRow = $headerRow + 1;
        foreach ($accidentes as $accidente) {
            $sheet->setCellValue('A' . $dataRow, $accidente['id_accidente'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $accidente['tipo'] ?? '');
            $sheet->setCellValue('C' . $dataRow, isset($accidente['fecha_hora']) ? date('d/m/Y H:i', strtotime($accidente['fecha_hora'])) : '');
            $sheet->setCellValue('D' . $dataRow, $accidente['descripcion'] ?? '');
            $sheet->setCellValue('E' . $dataRow, $accidente['lugar'] ?? '');
            $sheet->setCellValue('F' . $dataRow, $accidente['nombre_area'] ?? 'Sin área asignada');
            $sheet->setCellValue('G' . $dataRow, $accidente['clasificacion'] ?? 'Sin clasificar');
            $sheet->setCellValue('H' . $dataRow, $accidente['estado'] ?? 'Sin estado');
            $sheet->setCellValue('I' . $dataRow, $accidente['gravedad'] ?? 'Sin evaluar');
            $sheet->setCellValue('J' . $dataRow, $accidente['tipo_lesion'] ?? 'Sin especificar');
            $sheet->setCellValue('K' . $dataRow, $accidente['parte_cuerpo_afect'] ?? 'Sin especificar');
            $sheet->setCellValue('L' . $dataRow, $accidente['consecuencias'] ?? 'Sin especificar');
            $sheet->setCellValue('M' . $dataRow, $accidente['tipo_vinc_lab_'] ?? 'Sin especificar');
            $sheet->setCellValue('N' . $dataRow, $accidente['jornada_laboral'] ?? 'Sin especificar');
            $sheet->setCellValue('O' . $dataRow, $accidente['turno_mom_acc'] ?? 'Sin especificar');
            $sheet->setCellValue('P' . $dataRow, $accidente['uso_epp'] ?? 'Sin especificar');
            $sheet->setCellValue('Q' . $dataRow, $accidente['incapacidad_lab'] ?? 'Sin especificar');
            $sheet->setCellValue('R' . $dataRow, $accidente['aten_med_recibida'] ?? 'Sin especificar');
            $sheet->setCellValue('S' . $dataRow, $accidente['persona_informo'] ?? 'Sin especificar');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        foreach (range('A', 'S') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Establecer anchos mínimos y máximos
        $sheet->getColumnDimension('A')->setWidth(8);   // ID
        $sheet->getColumnDimension('D')->setWidth(40);  // Descripción
        $sheet->getColumnDimension('F')->setWidth(15);  // Área
        $sheet->getColumnDimension('L')->setWidth(30);  // Consecuencias
        $sheet->getColumnDimension('R')->setWidth(35);  // Atención Médica
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':S' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':S' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_accidentes/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_accidentes_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=accidentes&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function areas() {
        $this->onlyLogged();
        $nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        require_once __DIR__ . '/../models/Area.php';
        $areas = Area::getFiltered($nombre);
        
        if ($format === 'pdf') {
            $this->generateAreasPDF($areas, $nombre);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateAreasExcel($areas, $nombre);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/areas', [
            'areas' => $areas,
            'nombre' => $nombre,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateAreasPDF($areas, $filtroNombre = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Áreas de Trabajo'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroNombre) {
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->Cell(0, 5, utf8_decode('Filtro aplicado - Nombre: ' . $filtroNombre), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(70, 8, 'Nombre del Área', 1, 0, 'C');
        $pdf->Cell(100, 8, utf8_decode('Descripción'), 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 10);
        foreach ($areas as $area) {
            $pdf->Cell(20, 8, $area['id_area'] ?? '', 1, 0, 'C');
            $pdf->Cell(70, 8, utf8_decode($area['nombre'] ?? ''), 1, 0, 'L');
            $pdf->Cell(100, 8, utf8_decode($area['descripcion'] ?? ''), 1, 1, 'L');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_areas/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_areas_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=areas&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateAreasExcel($areas, $filtroNombre = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Áreas');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Áreas de Trabajo');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroNombre) {
            $sheet->setCellValue('A' . $currentRow, 'Filtro aplicado - Nombre: ' . $filtroNombre);
            $sheet->mergeCells('A' . $currentRow . ':C' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Nombre del Área', 'Descripción'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':C' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de áreas
        $dataRow = $headerRow + 1;
        foreach ($areas as $area) {
            $sheet->setCellValue('A' . $dataRow, $area['id_area'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $area['nombre'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $area['descripcion'] ?? '');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(50);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':C' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':C' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_areas/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_areas_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=areas&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function categorias() {
        $this->onlyLogged();
        $nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        require_once __DIR__ . '/../models/Categoria.php';
        $categorias = Categoria::getFiltered($nombre);
        
        if ($format === 'pdf') {
            $this->generateCategoriasPDF($categorias, $nombre);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateCategoriasExcel($categorias, $nombre);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/categorias', [
            'categorias' => $categorias,
            'nombre' => $nombre,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateCategoriasPDF($categorias, $filtroNombre = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Categorías'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroNombre) {
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->Cell(0, 5, utf8_decode('Filtro aplicado - Nombre: ' . $filtroNombre), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(15, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
        $pdf->Cell(50, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(40, 8, utf8_decode('Área'), 1, 0, 'C');
        $pdf->Cell(45, 8, 'Empleado Responsable', 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 8);
        foreach ($categorias as $categoria) {
            $pdf->Cell(15, 8, $categoria['id_categoria'] ?? '', 1, 0, 'C');
            $pdf->Cell(40, 8, utf8_decode($categoria['nombre'] ?? ''), 1, 0, 'L');
            $pdf->Cell(50, 8, utf8_decode($categoria['descripcion'] ?? ''), 1, 0, 'L');
            $pdf->Cell(40, 8, utf8_decode($categoria['area_nombre'] ?? 'Sin área'), 1, 0, 'L');
            $pdf->Cell(45, 8, utf8_decode($categoria['empleado_nombre'] ?? 'Sin empleado'), 1, 1, 'L');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_categorias/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_categorias_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=categorias&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateCategoriasExcel($categorias, $filtroNombre = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Categorías');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Categorías');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroNombre) {
            $sheet->setCellValue('A' . $currentRow, 'Filtro aplicado - Nombre: ' . $filtroNombre);
            $sheet->mergeCells('A' . $currentRow . ':E' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Nombre', 'Descripción', 'Área', 'Empleado Responsable'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, E
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':E' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de categorías
        $dataRow = $headerRow + 1;
        foreach ($categorias as $categoria) {
            $sheet->setCellValue('A' . $dataRow, $categoria['id_categoria'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $categoria['nombre'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $categoria['descripcion'] ?? '');
            $sheet->setCellValue('D' . $dataRow, $categoria['area_nombre'] ?? 'Sin área');
            $sheet->setCellValue('E' . $dataRow, $categoria['empleado_nombre'] ?? 'Sin empleado');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':E' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':E' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_categorias/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_categorias_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=categorias&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function riesgos() {
        $this->onlyLogged();
        $tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
        $area = isset($_GET['area']) ? trim($_GET['area']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        require_once __DIR__ . '/../models/Riesgo.php';
        // Usar getFilteredWithArea para incluir información del área
        $riesgos = Riesgo::getFilteredWithArea('', $tipo, '', $area);
        $areas = Area::all();
        
        if ($format === 'pdf') {
            $this->generateRiesgosPDF($riesgos, $tipo, $area);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateRiesgosExcel($riesgos, $tipo, $area);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/riesgos', [
            'riesgos' => $riesgos,
            'areas' => $areas,
            'tipo' => $tipo,
            'area' => $area,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateRiesgosPDF($riesgos, $filtroTipo = '', $area = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Riesgos'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroTipo || $area) {
            $filtros = [];
            if ($filtroTipo) $filtros[] = 'Tipo: ' . $filtroTipo;
            if ($area) $filtros[] = 'Área: ' . $area;
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(0, 5, utf8_decode('Filtros aplicados - ' . implode(', ', $filtros)), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tipo', 1, 0, 'C');
        $pdf->Cell(55, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(50, 8, utf8_decode('Condición Insegura'), 1, 0, 'C');
        $pdf->Cell(35, 8, utf8_decode('Área'), 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 9);
        foreach ($riesgos as $riesgo) {
            $pdf->Cell(10, 8, $riesgo['id_riesgo'] ?? '', 1, 0, 'C');
            $pdf->Cell(30, 8, utf8_decode(substr($riesgo['tipo'] ?? '', 0, 20)), 1, 0, 'L');
            $pdf->Cell(55, 8, utf8_decode(substr($riesgo['descripcion'] ?? 'Sin descripción', 0, 35)), 1, 0, 'L');
            $pdf->Cell(50, 8, utf8_decode(substr($riesgo['condicion_nombre'] ?? 'Sin condición asociada', 0, 30)), 1, 0, 'L');
            $pdf->Cell(35, 8, utf8_decode(substr($riesgo['nombre_area'] ?? 'Sin área', 0, 25)), 1, 1, 'L');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_riesgos/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_riesgos_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=riesgos&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateRiesgosExcel($riesgos, $filtroTipo = '', $area = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Riesgos');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Riesgos');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroTipo || $area) {
            $filtros = [];
            if ($filtroTipo) $filtros[] = 'Tipo: ' . $filtroTipo;
            if ($area) $filtros[] = 'Área: ' . $area;
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados - ' . implode(', ', $filtros));
            $sheet->mergeCells('A' . $currentRow . ':E' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Tipo', 'Descripción', 'Condición Insegura', 'Área'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, E
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':E' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de riesgos
        $dataRow = $headerRow + 1;
        foreach ($riesgos as $riesgo) {
            $sheet->setCellValue('A' . $dataRow, $riesgo['id_riesgo'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $riesgo['tipo'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $riesgo['descripcion'] ?? 'Sin descripción');
            $sheet->setCellValue('D' . $dataRow, $riesgo['condicion_nombre'] ?? 'Sin condición asociada');
            $sheet->setCellValue('E' . $dataRow, $riesgo['nombre_area'] ?? 'Sin área asignada');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(20);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':E' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':E' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_riesgos/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_riesgos_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=riesgos&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function inspecciones() {
        $this->onlyLogged();
        
        // Verificar si se está solicitando descarga
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        // Obtener filtros de la vista de reportes (nombres correctos)
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
        $tipo_inspeccion = isset($_GET['tipo_inspeccion']) ? $_GET['tipo_inspeccion'] : '';
        
        // Filtros adicionales (aunque no se usen en la vista de reportes)
        $estado_inspeccion = isset($_GET['estado_inspeccion']) ? $_GET['estado_inspeccion'] : '';
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
        $incidente = isset($_GET['incidente']) ? $_GET['incidente'] : '';
        $accidente = isset($_GET['accidente']) ? $_GET['accidente'] : '';
        $riesgo = isset($_GET['riesgo']) ? $_GET['riesgo'] : '';
        $condicion_insegura = isset($_GET['condicion_insegura']) ? $_GET['condicion_insegura'] : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : 'id_asc';
        
        // Obtener inspecciones filtradas usando el método específico para reportes
        $inspecciones = InspeccionLocativa::getFilteredForReports($fecha_inicio, $fecha_fin, $tipo_inspeccion, $estado_inspeccion, $categoria, $incidente, $accidente, $riesgo, $condicion_insegura, $orden);
        
        // Manejar descarga de PDF
        if ($format === 'pdf') {
            $this->generateInspeccionesPDFReporte($inspecciones, [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'tipo_inspeccion' => $tipo_inspeccion
            ]);
            return;
        }
        
        // Manejar descarga de Excel
        if ($format === 'excel') {
            $this->generateInspeccionesExcelReporte($inspecciones, [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'tipo_inspeccion' => $tipo_inspeccion
            ]);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $tipos_inspeccion = InspeccionLocativa::getTiposInspeccion();
        
        $this->view('reportes/inspecciones', [
            'inspecciones' => $inspecciones,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'tipo_inspeccion' => $tipo_inspeccion,
            'tipos_inspeccion' => $tipos_inspeccion,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    public function condicionesinseguras() {
        $this->onlyLogged();
        $nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
        $area = isset($_GET['area']) ? trim($_GET['area']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        require_once __DIR__ . '/../models/CondicionInsegura.php';
        // Usar getFilteredWithArea para incluir información del área
        $condiciones = CondicionInsegura::getFilteredWithArea('', $nombre, $area, 'nombre_asc');
        $areas = Area::all();
        
        if ($format === 'pdf') {
            $this->generateCondicionesInsegurasPDF($condiciones, $nombre, $area);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateCondicionesInsegurasExcel($condiciones, $nombre, $area);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/condicionesinseguras', [
            'condiciones' => $condiciones,
            'areas' => $areas,
            'nombre' => $nombre,
            'area' => $area,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateCondicionesInsegurasPDF($condiciones, $filtroNombre = '', $area = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Condiciones Inseguras'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroNombre || $area) {
            $filtros = [];
            if ($filtroNombre) $filtros[] = 'Nombre: ' . $filtroNombre;
            if ($area) $filtros[] = 'Área: ' . $area;
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(0, 5, utf8_decode('Filtros aplicados - ' . implode(', ', $filtros)), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
        $pdf->Cell(60, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(35, 8, 'Lugar', 1, 0, 'C');
        $pdf->Cell(35, 8, utf8_decode('Área'), 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 9);
        foreach ($condiciones as $condicion) {
            $pdf->Cell(10, 8, $condicion['id_cond_inseg'] ?? '', 1, 0, 'C');
            $pdf->Cell(40, 8, utf8_decode(substr($condicion['nombre'] ?? '', 0, 30)), 1, 0, 'L');
            $pdf->Cell(60, 8, utf8_decode(substr($condicion['descripcion'] ?? 'Sin descripción', 0, 40)), 1, 0, 'L');
            $pdf->Cell(35, 8, utf8_decode(substr($condicion['lugar'] ?? 'Sin especificar', 0, 25)), 1, 0, 'L');
            $pdf->Cell(35, 8, utf8_decode(substr($condicion['nombre_area'] ?? 'Sin área', 0, 25)), 1, 1, 'L');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_condicionesinseguras/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_condiciones_inseguras_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=condicionesinseguras&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateCondicionesInsegurasExcel($condiciones, $filtroNombre = '', $area = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Condiciones Inseguras');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Condiciones Inseguras');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroNombre || $area) {
            $filtros = [];
            if ($filtroNombre) $filtros[] = 'Nombre: ' . $filtroNombre;
            if ($area) $filtros[] = 'Área: ' . $area;
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados - ' . implode(', ', $filtros));
            $sheet->mergeCells('A' . $currentRow . ':E' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Nombre', 'Descripción', 'Lugar', 'Área'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, E
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':E' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de condiciones inseguras
        $dataRow = $headerRow + 1;
        foreach ($condiciones as $condicion) {
            $sheet->setCellValue('A' . $dataRow, $condicion['id_cond_inseg'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $condicion['nombre'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $condicion['descripcion'] ?? 'Sin descripción');
            $sheet->setCellValue('D' . $dataRow, $condicion['lugar'] ?? 'Sin especificar');
            $sheet->setCellValue('E' . $dataRow, $condicion['nombre_area'] ?? 'Sin área asignada');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':E' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':D' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_condicionesinseguras/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_condiciones_inseguras_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=condicionesinseguras&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function roles() {
        $this->onlyLogged();
        $nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        require_once __DIR__ . '/../models/Rol.php';
        $roles = Rol::getFiltered($nombre);
        
        if ($format === 'pdf') {
            $this->generateRolesPDF($roles, $nombre);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateRolesExcel($roles, $nombre);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/roles', [
            'roles' => $roles,
            'nombre' => $nombre,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateRolesPDF($roles, $filtroNombre = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Roles'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroNombre) {
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->Cell(0, 5, utf8_decode('Filtro aplicado - Nombre: ' . $filtroNombre), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(80, 8, 'Nombre del Rol', 1, 0, 'C');
        $pdf->Cell(80, 8, utf8_decode('Descripción'), 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 10);
        foreach ($roles as $rol) {
            $pdf->Cell(30, 8, $rol['id_Rol'] ?? '', 1, 0, 'C');
            $pdf->Cell(80, 8, utf8_decode($rol['nombre'] ?? ''), 1, 0, 'L');
            
            // Agregar descripción basada en el tipo de rol
            $descripcion = '';
            switch($rol['nombre']) {
                case 'admin':
                    $descripcion = 'Control total del sistema';
                    break;
                case 'supervisor':
                    $descripcion = 'Supervisión de operaciones';
                    break;
                case 'coordinador':
                    $descripcion = 'Coordinación de actividades';
                    break;
                case 'trabajador':
                    $descripcion = 'Acceso limitado para consulta';
                    break;
                default:
                    $descripcion = 'Rol personalizado';
            }
            $pdf->Cell(80, 8, utf8_decode($descripcion), 1, 1, 'L');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_roles/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_roles_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=roles&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateRolesExcel($roles, $filtroNombre = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Roles');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Roles');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroNombre) {
            $sheet->setCellValue('A' . $currentRow, 'Filtro aplicado - Nombre: ' . $filtroNombre);
            $sheet->mergeCells('A' . $currentRow . ':D' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Nombre del Rol', 'Descripción', 'Nivel de Acceso'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':D' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de roles
        $dataRow = $headerRow + 1;
        foreach ($roles as $rol) {
            // ID
            $sheet->setCellValue('A' . $dataRow, $rol['id_Rol'] ?? '');
            
            // Nombre
            $sheet->setCellValue('B' . $dataRow, $rol['nombre'] ?? '');
            
            // Descripción basada en el tipo de rol
            $descripcion = '';
            switch($rol['nombre']) {
                case 'admin':
                    $descripcion = 'Control total del sistema, gestión de usuarios y configuraciones';
                    break;
                case 'supervisor':
                    $descripcion = 'Supervisión de operaciones y revisión de reportes';
                    break;
                case 'coordinador':
                    $descripcion = 'Coordinación de actividades y seguimiento de procesos';
                    break;
                case 'trabajador':
                    $descripcion = 'Acceso limitado para consulta y registro básico';
                    break;
                default:
                    $descripcion = 'Rol personalizado del sistema';
            }
            $sheet->setCellValue('C' . $dataRow, $descripcion);
            
            // Nivel de acceso
            $nivelAcceso = '';
            switch($rol['nombre']) {
                case 'admin':
                    $nivelAcceso = 'Completo';
                    break;
                case 'supervisor':
                    $nivelAcceso = 'Limitado';
                    break;
                case 'coordinador':
                    $nivelAcceso = 'Solo lectura';
                    break;
                case 'trabajador':
                    $nivelAcceso = 'Básico';
                    break;
                default:
                    $nivelAcceso = 'Personalizado';
            }
            $sheet->setCellValue('D' . $dataRow, $nivelAcceso);
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(20);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':D' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':D' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_roles/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_roles_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=roles&excel_saved=' . urlencode($filename));
        exit;
    }
    
    public function usuarios() {
        $this->onlyLogged();
        $usuario = isset($_GET['usuario']) ? trim($_GET['usuario']) : '';
        $rol = isset($_GET['rol']) ? trim($_GET['rol']) : '';
        $format = isset($_GET['format']) ? $_GET['format'] : '';
        
        require_once __DIR__ . '/../models/User.php';
        $usuarios = User::getFiltered($usuario, $rol);
        
        if ($format === 'pdf') {
            $this->generateUsuariosPDF($usuarios, $usuario, $rol);
            return;
        }
        
        if ($format === 'excel') {
            $this->generateUsuariosExcel($usuarios, $usuario, $rol);
            return;
        }
        
        $userRole = $_SESSION['user']['rol'];
        $isTrabajador = ($userRole == 4);
        
        $this->view('reportes/usuarios', [
            'usuarios' => $usuarios,
            'usuario' => $usuario,
            'rol' => $rol,
            'isTrabajador' => $isTrabajador
        ]);
    }
    
    private function generateUsuariosPDF($usuarios, $filtroUsuario = '', $filtroRol = '') {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 10, utf8_decode('Reporte de Usuarios'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Fecha de generación
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode('Generado el: ' . date('d/m/Y H:i')), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Filtros aplicados
        if ($filtroUsuario || $filtroRol) {
            $pdf->SetFont('Arial', 'I', 9);
            $filtros = [];
            if ($filtroUsuario) $filtros[] = 'Usuario: ' . $filtroUsuario;
            if ($filtroRol) $filtros[] = 'Rol: ' . $filtroRol;
            $pdf->Cell(0, 5, utf8_decode('Filtros aplicados - ' . implode(', ', $filtros)), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        // Encabezados de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 8, 'Documento', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Tipo Doc', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Usuario', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Rol', 1, 0, 'C');
        $pdf->Cell(30, 8, utf8_decode('Teléfono'), 1, 1, 'C');
        
        // Datos de la tabla
        $pdf->SetFont('Arial', '', 9);
        foreach ($usuarios as $usuario) {
            $pdf->Cell(25, 8, $usuario['num_doc'] ?? '', 1, 0, 'C');
            $pdf->Cell(25, 8, utf8_decode($usuario['tipo_doc'] ?? ''), 1, 0, 'C');
            $pdf->Cell(50, 8, utf8_decode($usuario['usuario'] ?? ''), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode($usuario['rol_nombre'] ?? $usuario['rol'] ?? ''), 1, 0, 'C');
            $pdf->Cell(30, 8, $usuario['telefono'] ?? '', 1, 1, 'C');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_usuarios/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_usuarios_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=usuarios&pdf_saved=' . urlencode($filename));
        exit;
    }
    
    private function generateUsuariosExcel($usuarios, $filtroUsuario = '', $filtroRol = '') {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Usuarios');
        
        // Título principal
        $sheet->setCellValue('A1', 'Reporte de Usuarios');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Fecha de generación
        $sheet->setCellValue('A2', 'Generado el: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        
        $currentRow = 3;
        
        // Filtros aplicados
        if ($filtroUsuario || $filtroRol) {
            $filtros = [];
            if ($filtroUsuario) $filtros[] = 'Usuario: ' . $filtroUsuario;
            if ($filtroRol) $filtros[] = 'Rol: ' . $filtroRol;
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados - ' . implode(', ', $filtros));
            $sheet->mergeCells('A' . $currentRow . ':E' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));
            $currentRow++;
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['Documento', 'Tipo Documento', 'Usuario', 'Rol', 'Teléfono'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, E
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':E' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de usuarios
        $dataRow = $headerRow + 1;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue('A' . $dataRow, $usuario['num_doc'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $usuario['tipo_doc'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $usuario['usuario'] ?? '');
            $sheet->setCellValue('D' . $dataRow, $usuario['rol_nombre'] ?? $usuario['rol'] ?? '');
            $sheet->setCellValue('E' . $dataRow, $usuario['telefono'] ?? '');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':E' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':E' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_usuarios/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_usuarios_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=usuarios&excel_saved=' . urlencode($filename));
        exit;
    }

    private function generateInspeccionesPDFReporte($inspecciones, $filtros = []) {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
        
        // Crear PDF
        $pdf = new FPDF();
        $pdf->AddPage('L'); // Paisaje para más espacio
        $pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $pdf->Cell(0, 15, utf8_decode('REPORTE DE INSPECCIONES LOCATIVAS'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Información del reporte
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 8, utf8_decode('Generado el: ' . date('d/m/Y H:i:s')), 0, 1, 'R');
        $pdf->Cell(0, 8, utf8_decode('Total de registros: ' . count($inspecciones)), 0, 1, 'R');
        $pdf->Ln(5);
        
        // Mostrar filtros aplicados si existen
        if (!empty($filtros['fecha_inicio']) || !empty($filtros['fecha_fin']) || !empty($filtros['tipo_inspeccion'])) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 8, utf8_decode('Filtros aplicados:'), 0, 1, 'L');
            $pdf->SetFont('Arial', '', 9);
            if (!empty($filtros['fecha_inicio'])) $pdf->Cell(0, 6, utf8_decode('- Fecha inicio: ' . $filtros['fecha_inicio']), 0, 1, 'L');
            if (!empty($filtros['fecha_fin'])) $pdf->Cell(0, 6, utf8_decode('- Fecha fin: ' . $filtros['fecha_fin']), 0, 1, 'L');
            if (!empty($filtros['tipo_inspeccion'])) $pdf->Cell(0, 6, utf8_decode('- Tipo: ' . $filtros['tipo_inspeccion']), 0, 1, 'L');
            $pdf->Ln(5);
        }
        
        if (empty($inspecciones)) {
            $pdf->SetFont('Arial', 'I', 12);
            $pdf->Cell(0, 20, utf8_decode('No se encontraron inspecciones locativas con los filtros aplicados.'), 0, 1, 'C');
        } else {
            // Encabezados de tabla estilo compacto
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetFillColor(68, 114, 196);
            $pdf->SetTextColor(255, 255, 255);
            
            $pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
            $pdf->Cell(30, 8, utf8_decode('Tipo'), 1, 0, 'C', true);
            $pdf->Cell(30, 8, utf8_decode('Fecha'), 1, 0, 'C', true);
            $pdf->Cell(20, 8, 'Estado', 1, 0, 'C', true);
            $pdf->Cell(25, 8, utf8_decode('Categoría'), 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Empleado', 1, 0, 'C', true);
            $pdf->Cell(20, 8, utf8_decode('Área'), 1, 0, 'C', true);
            $pdf->Cell(50, 8, utf8_decode('Descripción'), 1, 1, 'C', true);
            
            // Datos de las inspecciones
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetTextColor(0, 0, 0);
            $fill = false;
            
            foreach ($inspecciones as $inspeccion) {
                if ($fill) {
                    $pdf->SetFillColor(242, 242, 242);
                } else {
                    $pdf->SetFillColor(255, 255, 255);
                }
                
                // Truncar textos largos
                $descripcion = substr($inspeccion['descripcion'] ?? '', 0, 40) . (strlen($inspeccion['descripcion'] ?? '') > 40 ? '...' : '');
                $empleado = !empty($inspeccion['empleado_nombre']) ? substr($inspeccion['empleado_nombre'], 0, 20) : 'Sin empleado';
                $area = !empty($inspeccion['area_nombre']) ? substr($inspeccion['area_nombre'], 0, 15) : 'Sin área';
                $categoria = substr($inspeccion['categoria_nombre'] ?? '', 0, 20);
                
                $pdf->Cell(15, 8, $inspeccion['id_insp_loc'] ?? '', 1, 0, 'C', true);
                $pdf->Cell(30, 8, utf8_decode(substr($inspeccion['tipo_inspeccion'] ?? '', 0, 20)), 1, 0, 'L', true);
                $pdf->Cell(30, 8, isset($inspeccion['fecha_hora']) ? date('d/m/Y H:i', strtotime($inspeccion['fecha_hora'])) : '', 1, 0, 'C', true);
                $pdf->Cell(20, 8, utf8_decode(substr($inspeccion['estado_inspeccion'] ?? '', 0, 15)), 1, 0, 'C', true);
                $pdf->Cell(25, 8, utf8_decode($categoria), 1, 0, 'L', true);
                $pdf->Cell(30, 8, utf8_decode($empleado), 1, 0, 'L', true);
                $pdf->Cell(20, 8, utf8_decode($area), 1, 0, 'L', true);
                $pdf->Cell(50, 8, utf8_decode($descripcion), 1, 1, 'L', true);
                
                $fill = !$fill;
            }
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_pdf/pdfs_inspecciones/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_inspecciones_' . date('Y-m-d_H-i-s') . '.pdf';
        $filepath = $dir . $filename;
        
        // Guardar PDF
        $pdf->Output('F', $filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=inspecciones&pdf_saved=' . urlencode($filename));
        exit;
    }

    private function generateInspeccionesExcelReporte($inspecciones, $filtros = []) {
        
        // Crear nueva spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Inspecciones Locativas');
        
        // Configurar documento
        $spreadsheet->getProperties()
            ->setCreator('Sistema RACI')
            ->setTitle('Reporte de Inspecciones Locativas')
            ->setSubject('Inspecciones Locativas')
            ->setDescription('Reporte generado desde el sistema RACI');
        
        // Título principal
        $sheet->setCellValue('A1', 'REPORTE DE INSPECCIONES LOCATIVAS');
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Información del reporte
        $currentRow = 3;
        $sheet->setCellValue('A' . $currentRow, 'Generado el: ' . date('d/m/Y H:i:s'));
        $sheet->setCellValue('A' . ($currentRow + 1), 'Total de registros: ' . count($inspecciones));
        $currentRow += 3;
        
        // Mostrar filtros si existen
        if (!empty($filtros['fecha_inicio']) || !empty($filtros['fecha_fin']) || !empty($filtros['tipo_inspeccion'])) {
            $sheet->setCellValue('A' . $currentRow, 'Filtros aplicados:');
            $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
            $currentRow++;
            
            if (!empty($filtros['fecha_inicio'])) {
                $sheet->setCellValue('A' . $currentRow, '- Fecha inicio: ' . $filtros['fecha_inicio']);
                $currentRow++;
            }
            if (!empty($filtros['fecha_fin'])) {
                $sheet->setCellValue('A' . $currentRow, '- Fecha fin: ' . $filtros['fecha_fin']);
                $currentRow++;
            }
            if (!empty($filtros['tipo_inspeccion'])) {
                $sheet->setCellValue('A' . $currentRow, '- Tipo: ' . $filtros['tipo_inspeccion']);
                $currentRow++;
            }
        }
        
        $currentRow++; // Espacio en blanco
        
        // Encabezados
        $headers = ['ID', 'Tipo Inspección', 'Fecha y Hora', 'Descripción', 'Estado', 'Elementos Trabajo', 'Observaciones', 'Categoría', 'Incidente', 'Accidente', 'Riesgo', 'Condición Insegura', 'Empleado', 'Área'];
        $headerRow = $currentRow;
        
        foreach ($headers as $index => $header) {
            $column = chr(65 + $index); // A, B, C, D, etc.
            $sheet->setCellValue($column . $headerRow, $header);
        }
        
        // Estilo de encabezados
        $headerRange = 'A' . $headerRow . ':N' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Datos de inspecciones
        $dataRow = $headerRow + 1;
        foreach ($inspecciones as $inspeccion) {
            $sheet->setCellValue('A' . $dataRow, $inspeccion['id_insp_loc'] ?? '');
            $sheet->setCellValue('B' . $dataRow, $inspeccion['tipo_inspeccion'] ?? '');
            $sheet->setCellValue('C' . $dataRow, $inspeccion['fecha_hora'] ?? '');
            $sheet->setCellValue('D' . $dataRow, $inspeccion['descripcion'] ?? '');
            $sheet->setCellValue('E' . $dataRow, $inspeccion['estado_inspeccion'] ?? '');
            $sheet->setCellValue('F' . $dataRow, $inspeccion['element_trab'] ?? '');
            $sheet->setCellValue('G' . $dataRow, $inspeccion['observaciones'] ?? '');
            $sheet->setCellValue('H' . $dataRow, $inspeccion['categoria_nombre'] ?? '');
            $sheet->setCellValue('I' . $dataRow, $inspeccion['incidente_tipo'] ?? '');
            $sheet->setCellValue('J' . $dataRow, $inspeccion['accidente_tipo'] ?? '');
            $sheet->setCellValue('K' . $dataRow, $inspeccion['riesgo_tipo'] ?? '');
            $sheet->setCellValue('L' . $dataRow, $inspeccion['condicion_insegura_nombre'] ?? '');
            $sheet->setCellValue('M' . $dataRow, !empty($inspeccion['empleado_nombre']) ? $inspeccion['empleado_nombre'] : 'Sin empleado');
            $sheet->setCellValue('N' . $dataRow, !empty($inspeccion['area_nombre']) ? $inspeccion['area_nombre'] : 'Sin área');
            
            $dataRow++;
        }
        
        // Ajustar ancho de columnas
        $sheet->getColumnDimension('A')->setWidth(8);  // ID
        $sheet->getColumnDimension('B')->setWidth(20); // Tipo Inspección
        $sheet->getColumnDimension('C')->setWidth(18); // Fecha y Hora
        $sheet->getColumnDimension('D')->setWidth(35); // Descripción
        $sheet->getColumnDimension('E')->setWidth(15); // Estado
        $sheet->getColumnDimension('F')->setWidth(20); // Elementos Trabajo
        $sheet->getColumnDimension('G')->setWidth(35); // Observaciones
        $sheet->getColumnDimension('H')->setWidth(15); // Categoría
        $sheet->getColumnDimension('I')->setWidth(15); // Incidente
        $sheet->getColumnDimension('J')->setWidth(15); // Accidente
        $sheet->getColumnDimension('K')->setWidth(15); // Riesgo
        $sheet->getColumnDimension('L')->setWidth(25); // Condición Insegura
        $sheet->getColumnDimension('M')->setWidth(20); // Empleado
        $sheet->getColumnDimension('N')->setWidth(15); // Área
        
        // Aplicar bordes a toda la tabla
        $tableRange = 'A' . $headerRow . ':N' . ($dataRow - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Alternar colores de filas
        for ($row = $headerRow + 1; $row < $dataRow; $row += 2) {
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F2F2F2');
        }
        
        // Crear directorio si no existe
        $dir = __DIR__ . '/../Reportes_Excel/excels_inspecciones/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Nombre del archivo
        $filename = 'reporte_inspecciones_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filepath = $dir . $filename;
        
        // Guardar Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);
        
        // Redirigir con mensaje de éxito
        header('Location: ?controller=reportes&action=inspecciones&excel_saved=' . urlencode($filename));
        exit;
    }
}
