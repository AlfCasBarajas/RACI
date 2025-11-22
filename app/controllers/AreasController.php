<?php
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';

class AreasController extends Controller {
    private function onlyLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /RACI/?controller=login&action=index');
            exit;
        }
    }

    private function checkNotCoordinadorForEdit() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 3) { // 3 es el ID del rol coordinador
            header('Location: /RACI/?controller=areas&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=areas&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $filtro_nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $areas = Area::getFiltered($filtro_nombre, $orden);
        
        // Obtener el rol del usuario actual
    $userRole = $_SESSION['user']['rol'];
    $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
    $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
    $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
    $this->view('areas/index', ['areas' => $areas, 'isCoordinador' => $isCoordinador, 'isSupervisor' => $isSupervisor, 'isTrabajador' => $isTrabajador]);
    }

    public function create() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $this->view('areas/create');
    }

    public function store() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion']
        ];
        Area::create($data);
        header('Location: ?controller=areas&action=index');
        exit;
    }

    public function edit() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $area = Area::find($id);
        $this->view('areas/edit', ['area' => $area]);
    }

    public function update() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion']
        ];
        Area::update($id, $data);
        header('Location: ?controller=areas&action=index');
        exit;
    }

    public function delete() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            Area::delete($id);
            $_SESSION['success'] = 'Área eliminada correctamente';
        } catch (Exception $e) {
            // Verificar si es un error de constraint de clave foránea
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'Integrity constraint violation') !== false || 
                strpos($errorMessage, 'foreign key constraint fails') !== false) {
                $_SESSION['error'] = 'Esta área no se puede eliminar porque está siendo utilizada por otros registros en el sistema.\n\nPara poder eliminarla, primero debe reasignar o eliminar todos los registros que la utilizan.';
            } else {
                $_SESSION['error'] = $errorMessage;
            }
        }
        
        header('Location: ?controller=areas&action=index');
        exit;
    }
}
