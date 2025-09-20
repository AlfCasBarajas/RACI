<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Rol.php';

class RolesController extends Controller {
    private function onlyLogged() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /RACI/?controller=login&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $filtro = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['orden']) && in_array($_GET['orden'], ['asc','desc']) ? $_GET['orden'] : '';
        $roles = Rol::getFiltered($filtro, $orden);
        include __DIR__ . '/../views/roles/index.php';
    }

    public function create() {
        $this->onlyLogged();
        include __DIR__ . '/../views/roles/create.php';
    }

    public function store() {
        $this->onlyLogged();
        if (isset($_POST['nombre'])) {
            Rol::create($_POST['nombre']);
            header('Location: /RACI/?controller=roles&action=index');
            exit;
        }
    }

    public function edit($id) {
        $this->onlyLogged();
        $rol = Rol::getById($id);
        include __DIR__ . '/../views/roles/edit.php';
    }

    public function update($id) {
        $this->onlyLogged();
        if (isset($_POST['nombre'])) {
            Rol::update($id, $_POST['nombre']);
            header('Location: /RACI/?controller=roles&action=index');
            exit;
        }
    }

    public function delete($id) {
        $this->onlyLogged();
        Rol::delete($id);
        header('Location: /RACI/?controller=roles&action=index');
        exit;
    }
}
