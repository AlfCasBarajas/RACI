<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../core/Controller.php';

class UsersController extends Controller {
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
            header('Location: /RACI/?controller=users&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=users&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $filtro_doc = isset($_GET['filtro_doc']) ? trim($_GET['filtro_doc']) : '';
        $filtro_nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $filtro_rol = isset($_GET['filtro_rol']) ? $_GET['filtro_rol'] : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $usuarios = User::getFiltered($filtro_doc, $filtro_nombre, $filtro_rol, $orden);
        $roles = Rol::all();
        
        // Obtener el rol del usuario actual
    $userRole = $_SESSION['user']['rol'];
    $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
    $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
    $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
    $this->view('users/index', ['usuarios' => $usuarios, 'roles' => $roles, 'isCoordinador' => $isCoordinador, 'isSupervisor' => $isSupervisor, 'isTrabajador' => $isTrabajador]);
    }

    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $roles = Rol::all();
        $this->view('users/create', ['roles' => $roles]);
    }

    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $data = [
            'num_doc' => $_POST['num_doc'],
            'tipo_doc' => $_POST['tipo_doc'],
            'usuario' => $_POST['usuario'],
            'rol' => $_POST['rol'],
            'telefono' => $_POST['telefono'],
            'contrasena' => $_POST['contrasena']
        ];
        User::create($data);
        header('Location: ?controller=users&action=index');
        exit;
    }

    public function edit() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $num_doc = $_GET['id'];
        $usuario = User::find($num_doc);
        $roles = Rol::all();
        $this->view('users/edit', ['usuario' => $usuario, 'roles' => $roles]);
    }

    public function update() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $num_doc = $_GET['id'];
        $data = [
            'tipo_doc' => $_POST['tipo_doc'],
            'usuario' => $_POST['usuario'],
            'rol' => $_POST['rol'],
            'telefono' => $_POST['telefono'],
            'contrasena' => $_POST['contrasena']
        ];
        User::update($num_doc, $data);
        header('Location: ?controller=users&action=index');
        exit;
    }

    public function delete() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        User::delete($id);
        header('Location: ?controller=users&action=index');
        exit;
    }
}
