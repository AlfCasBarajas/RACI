<?php
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

class CondicionesInsegurasController extends Controller {
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
            header('Location: /RACI/?controller=condicionesinseguras&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=condicionesinseguras&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'nombre_asc';
        $condiciones = CondicionInsegura::getFilteredWithArea('', $nombre, $area, $orden);
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('condicionesinseguras/index', [
            'condiciones' => $condiciones,
            'filtro_nombre' => $nombre,
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
        $this->view('condicionesinseguras/create', [
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=condicionesinseguras&action=create&error=area_required');
            exit;
        }
        
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'lugar' => $_POST['lugar'],
            'area_id' => $_POST['area_id']
        ];
        
        try {
            // Crear la condición insegura con área directamente
            $success = CondicionInsegura::create($data);
            
            if (!$success) {
                throw new Exception('Error al crear la condición insegura');
            }
            
            header('Location: ?controller=condicionesinseguras&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en store condiciones inseguras: ' . $e->getMessage());
            header('Location: ?controller=condicionesinseguras&action=create&error=database_error');
            exit;
        }
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $condicion = CondicionInsegura::find($id);
        $areas = Area::all();
        
        $this->view('condicionesinseguras/edit', [
            'condicion' => $condicion,
            'areas' => $areas,
            'area_actual' => $condicion['area_id_area'] ?? null
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=condicionesinseguras&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'lugar' => $_POST['lugar'],
            'area_id' => $_POST['area_id']
        ];
        
        try {
            // Actualizar la condición insegura con área directamente
            $success = CondicionInsegura::update($id, $data);
            
            if (!$success) {
                throw new Exception('Error al actualizar la condición insegura');
            }
            
            header('Location: ?controller=condicionesinseguras&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en update condiciones inseguras: ' . $e->getMessage());
            header('Location: ?controller=condicionesinseguras&action=edit&id=' . $id . '&error=database_error');
            exit;
        }
    }
    public function delete() {
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            CondicionInsegura::delete($id);
            $_SESSION['success'] = 'Condición insegura eliminada correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=condicionesinseguras&action=index');
        exit;
    }
}
