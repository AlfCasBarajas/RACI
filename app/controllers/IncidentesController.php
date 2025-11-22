<?php
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Area.php';
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
        $fecha = isset($_GET['filtro_fecha']) ? $_GET['filtro_fecha'] : '';
        $lugar = isset($_GET['filtro_lugar']) ? trim($_GET['filtro_lugar']) : '';
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $incidentes = Incidente::getFilteredWithArea($tipo, $fecha, $lugar, $area, $orden);
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('incidentes/index', [
            'incidentes' => $incidentes,
            'filtro_tipo' => $tipo,
            'filtro_fecha' => $fecha,
            'filtro_lugar' => $lugar,
            'filtro_area' => $area,
            'filtro_orden' => $orden,
            'areas' => $areas,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $areas = Area::all();
        $this->view('incidentes/create', [
            'areas' => $areas
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
            'area_id' => $_POST['area_id']
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
        
        $this->view('incidentes/edit', [
            'incidente' => $incidente,
            'areas' => $areas,
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
            'area_id' => $_POST['area_id']
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
