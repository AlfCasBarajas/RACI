<?php
require_once __DIR__ . '/../models/Riesgo.php';
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

class RiesgosController extends Controller {
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
            header('Location: /RACI/?controller=riesgos&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=riesgos&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $condicion = isset($_GET['filtro_condicion']) ? $_GET['filtro_condicion'] : '';
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $riesgos = Riesgo::getFilteredWithArea('', $tipo, $condicion, $area, $orden);
        $condiciones = CondicionInsegura::all();
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('riesgos/index', [
            'riesgos' => $riesgos,
            'condiciones' => $condiciones,
            'areas' => $areas,
            'filtro_tipo' => $tipo,
            'filtro_condicion' => $condicion,
            'filtro_area' => $area,
            'filtro_orden' => $orden,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $condiciones = CondicionInsegura::all();
        $areas = Area::all();
        $this->view('riesgos/create', [
            'condiciones' => $condiciones,
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=riesgos&action=create&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'condicion_insegura_id_cond_inseg' => $_POST['condicion_insegura_id_cond_inseg'],
            'area_id' => $_POST['area_id']
        ];
        
        try {
            // Crear el riesgo con área directamente
            $success = Riesgo::create($data);
            
            if (!$success) {
                throw new Exception('Error al crear el riesgo');
            }
            
            header('Location: ?controller=riesgos&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en store riesgos: ' . $e->getMessage());
            header('Location: ?controller=riesgos&action=create&error=database_error');
            exit;
        }
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $riesgo = Riesgo::find($id);
        $condiciones = CondicionInsegura::all();
        $areas = Area::all();
        
        $this->view('riesgos/edit', [
            'riesgo' => $riesgo,
            'condiciones' => $condiciones,
            'areas' => $areas,
            'area_actual' => $riesgo['area_id_area'] ?? null
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=riesgos&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'condicion_insegura_id_cond_inseg' => $_POST['condicion_insegura_id_cond_inseg'],
            'area_id' => $_POST['area_id']
        ];
        
        try {
            // Actualizar el riesgo con área directamente
            $success = Riesgo::update($id, $data);
            
            if (!$success) {
                throw new Exception('Error al actualizar el riesgo');
            }
            
            header('Location: ?controller=riesgos&action=index');
            exit;
            
        } catch (Exception $e) {
            error_log('Error en update riesgos: ' . $e->getMessage());
            header('Location: ?controller=riesgos&action=edit&id=' . $id . '&error=database_error');
            exit;
        }
    }
    public function delete() {
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            Riesgo::delete($id);
            $_SESSION['success'] = 'Riesgo eliminado correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=riesgos&action=index');
        exit;
    }
}
