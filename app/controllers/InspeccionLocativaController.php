<?php
require_once __DIR__ . '/../models/InspeccionLocativa.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../models/Riesgo.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';

class InspeccionLocativaController extends Controller {
    private function onlyLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /RACI/?controller=login&action=index');
            exit;
        }
    }

    private function checkNotCoordinadorForDelete() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 3) { // 3 es el ID del rol coordinador
            header('Location: /RACI/?controller=inspeccionlocativa&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=inspeccionlocativa&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $id = isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '';
        $tipo_inspeccion = isset($_GET['filtro_tipo_inspeccion']) ? trim($_GET['filtro_tipo_inspeccion']) : '';
        $fecha_hora = isset($_GET['filtro_fecha_hora']) ? $_GET['filtro_fecha_hora'] : '';
        $estado_inspeccion = isset($_GET['filtro_estado_inspeccion']) ? trim($_GET['filtro_estado_inspeccion']) : '';
        $categoria = isset($_GET['filtro_categoria']) ? trim($_GET['filtro_categoria']) : '';
        $incidente = isset($_GET['filtro_incidente']) ? trim($_GET['filtro_incidente']) : '';
        $accidente = isset($_GET['filtro_accidente']) ? trim($_GET['filtro_accidente']) : '';
        $riesgo = isset($_GET['filtro_riesgo']) ? trim($_GET['filtro_riesgo']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $inspecciones = InspeccionLocativa::getFiltered($id, $tipo_inspeccion, $fecha_hora, $estado_inspeccion, $categoria, $incidente, $accidente, $riesgo, $orden);
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('inspeccioneslocativas/index', [
            'inspecciones' => $inspecciones,
            'filtro_id' => $id,
            'filtro_tipo_inspeccion' => $tipo_inspeccion,
            'filtro_fecha_hora' => $fecha_hora,
            'filtro_estado_inspeccion' => $estado_inspeccion,
            'filtro_categoria' => $categoria,
            'filtro_incidente' => $incidente,
            'filtro_accidente' => $accidente,
            'filtro_riesgo' => $riesgo,
            'filtro_orden' => $orden,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $categorias = Categoria::all();
        $incidentes = Incidente::all();
        $accidentes = Accidente::all();
        $riesgos = Riesgo::all();
        $empleados = Empleado::all();
        $areas = Area::all();
        $this->view('inspeccioneslocativas/create', [
            'categorias' => $categorias,
            'incidentes' => $incidentes,
            'accidentes' => $accidentes,
            'riesgos' => $riesgos
            ,
            'empleados' => $empleados,
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $data = [
            'tipo_inspeccion' => $_POST['tipo_inspeccion'],
            'fecha_hora' => $_POST['fecha_hora'],
            'descripcion' => $_POST['descripcion'],
            'estado_inspeccion' => $_POST['estado_inspeccion'],
            'element_trab' => $_POST['element_trab'],
            'observaciones' => $_POST['observaciones'],
            'categoria_id_categoria' => !empty($_POST['categoria_id_categoria']) ? $_POST['categoria_id_categoria'] : null,
            'empleado_id_empleado' => !empty($_POST['empleado_id_empleado']) ? $_POST['empleado_id_empleado'] : null,
            'area_id_area' => !empty($_POST['area_id_area']) ? $_POST['area_id_area'] : null,
            'incidente_id_incidente' => !empty($_POST['incidente_id_incidente']) ? $_POST['incidente_id_incidente'] : null,
            'accidente_id_accidente' => !empty($_POST['accidente_id_accidente']) ? $_POST['accidente_id_accidente'] : null,
            'riesgo_id_riesgo' => !empty($_POST['riesgo_id_riesgo']) ? $_POST['riesgo_id_riesgo'] : null
        ];
        
        try {
            InspeccionLocativa::create($data);
            header('Location: ?controller=inspeccionlocativa&action=index');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?controller=inspeccionlocativa&action=create');
            exit;
        }
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $inspeccion = InspeccionLocativa::find($id);
        $categorias = Categoria::all();
        $incidentes = Incidente::all();
        $accidentes = Accidente::all();
        $riesgos = Riesgo::all();
        $empleados = Empleado::all();
        $areas = Area::all();
        $this->view('inspeccioneslocativas/edit', [
            'inspeccion' => $inspeccion,
            'categorias' => $categorias,
            'incidentes' => $incidentes,
            'accidentes' => $accidentes,
            'riesgos' => $riesgos
            ,
            'empleados' => $empleados,
            'areas' => $areas
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $data = [
            'tipo_inspeccion' => $_POST['tipo_inspeccion'],
            'fecha_hora' => $_POST['fecha_hora'],
            'act_economica' => $_POST['act_economica'],
            'descripcion' => $_POST['descripcion'],
            'estado_inspeccion' => $_POST['estado_inspeccion'],
            'element_trab' => $_POST['element_trab'],
            'observaciones' => $_POST['observaciones'],
            'categoria_id_categoria' => !empty($_POST['categoria_id_categoria']) ? $_POST['categoria_id_categoria'] : null,
            'empleado_id_empleado' => !empty($_POST['empleado_id_empleado']) ? $_POST['empleado_id_empleado'] : null,
            'area_id_area' => !empty($_POST['area_id_area']) ? $_POST['area_id_area'] : null,
            'incidente_id_incidente' => !empty($_POST['incidente_id_incidente']) ? $_POST['incidente_id_incidente'] : null,
            'accidente_id_accidente' => !empty($_POST['accidente_id_accidente']) ? $_POST['accidente_id_accidente'] : null,
            'riesgo_id_riesgo' => !empty($_POST['riesgo_id_riesgo']) ? $_POST['riesgo_id_riesgo'] : null
        ];
        
        try {
            InspeccionLocativa::update($id, $data);
            header('Location: ?controller=inspeccionlocativa&action=index');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?controller=inspeccionlocativa&action=edit&id=' . $id);
            exit;
        }
    }
    public function delete() {
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            InspeccionLocativa::delete($id);
            $_SESSION['success'] = 'Inspección locativa eliminada correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=inspeccionlocativa&action=index');
        exit;
    }
}
