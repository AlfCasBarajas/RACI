<?php
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

class IncidentesController extends Controller {
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
            header('Location: /RACI/?controller=incidentes&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=incidentes&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $fecha_inicio = isset($_GET['filtro_fecha_inicio']) ? $_GET['filtro_fecha_inicio'] : '';
        $fecha_fin = isset($_GET['filtro_fecha_fin']) ? $_GET['filtro_fecha_fin'] : '';
        $lugar = isset($_GET['filtro_lugar']) ? trim($_GET['filtro_lugar']) : '';
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $empleado = isset($_GET['filtro_empleado']) ? $_GET['filtro_empleado'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $incidentes = Incidente::getFilteredWithArea($tipo, $fecha_inicio, $fecha_fin, $lugar, $area, $empleado, $orden);
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
        // Obtener todos los empleados para mostrar nombres
        $empleados = Empleado::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('incidentes/index', [
            'incidentes' => $incidentes,
            'filtro_tipo' => $tipo,
            'filtro_fecha_inicio' => $fecha_inicio,
            'filtro_fecha_fin' => $fecha_fin,
            'filtro_lugar' => $lugar,
            'filtro_area' => $area,
            'filtro_empleado' => $empleado,
            'filtro_orden' => $orden,
            'areas' => $areas,
            'empleados' => $empleados,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $areas = Area::all();
        $empleados = Empleado::all();
        $this->view('incidentes/create', [
            'areas' => $areas,
            'empleados' => $empleados
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=incidentes&action=create&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha'],
            'lugar' => $_POST['lugar'],
            'tipo_vinc_lab' => $_POST['tipo_vinc_lab'] ?? null,
            'jornada_laboral' => $_POST['jornada_laboral'] ?? null,
            'turno_mom_inc' => $_POST['turno_mom_inc'] ?? null,
            'uso_epp' => $_POST['uso_epp'] ?? null,
            'area_id' => $_POST['area_id'],
            'empleado_id' => $_POST['empleado_id'] ?? null
        ];
        
        try {
            // Crear el incidente con área directamente
            $success = Incidente::create($data);
            
            if (!$success) {
                throw new Exception('Error al crear el incidente');
            }
            
            header('Location: ?controller=incidentes&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en store incidentes: ' . $e->getMessage());
            header('Location: ?controller=incidentes&action=create&error=database_error');
            exit;
        }
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $incidente = Incidente::find($id);
        $areas = Area::all();
        $empleados = Empleado::all();
        
        $this->view('incidentes/edit', [
            'incidente' => $incidente,
            'areas' => $areas,
            'empleados' => $empleados,
            'area_actual' => $incidente['area_id_area'] ?? null
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=incidentes&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha'],
            'lugar' => $_POST['lugar'],
            'tipo_vinc_lab' => $_POST['tipo_vinc_lab'] ?? null,
            'jornada_laboral' => $_POST['jornada_laboral'] ?? null,
            'turno_mom_inc' => $_POST['turno_mom_inc'] ?? null,
            'uso_epp' => $_POST['uso_epp'] ?? null,
            'area_id' => $_POST['area_id'],
            'empleado_id' => $_POST['empleado_id'] ?? null
        ];
        
        try {
            // Actualizar el incidente con área directamente
            $success = Incidente::update($id, $data);
            
            if (!$success) {
                throw new Exception('Error al actualizar el incidente');
            }
            
            header('Location: ?controller=incidentes&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en update incidentes: ' . $e->getMessage());
            header('Location: ?controller=incidentes&action=edit&id=' . $id . '&error=database_error');
            exit;
        }
    }
    public function delete() {
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        Incidente::delete($id);
        header('Location: ?controller=incidentes&action=index');
        exit;
    }
}
