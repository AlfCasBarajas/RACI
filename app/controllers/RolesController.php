<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Rol.php';

class RolesController extends Controller {
    private function onlyLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /RACI/?controller=login&action=index');
            exit;
        }
    }

    private function checkNotCoordinador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 3) { // 3 es el ID del rol coordinador
            header('Location: /RACI/?controller=roles&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=roles&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $filtro = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['orden']) && in_array($_GET['orden'], ['asc','desc']) ? $_GET['orden'] : '';
        $roles = Rol::getFiltered($filtro, $orden);
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        include __DIR__ . '/../views/roles/index.php';
    }

    public function create() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        include __DIR__ . '/../views/roles/create.php';
    }

    public function store() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        if (isset($_POST['nombre'])) {
            Rol::create($_POST['nombre']);
            header('Location: /RACI/?controller=roles&action=index');
            exit;
        }
    }

    public function edit($id) {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        $rol = Rol::getById($id);
        include __DIR__ . '/../views/roles/edit.php';
    }

    public function update($id) {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        if (isset($_POST['nombre'])) {
            Rol::update($id, $_POST['nombre']);
            header('Location: /RACI/?controller=roles&action=index');
            exit;
        }
    }

    public function delete($id) {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        
        try {
            Rol::delete($id);
            $_SESSION['success'] = 'Rol eliminado correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: /RACI/?controller=roles&action=index');
        exit;
    }
}
