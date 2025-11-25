<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

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
        $filtro_usuario = isset($_GET['filtro_usuario']) ? trim($_GET['filtro_usuario']) : '';
        $filtro_rol = isset($_GET['filtro_rol']) ? $_GET['filtro_rol'] : '';
        $filtro_doc = isset($_GET['filtro_doc']) ? trim($_GET['filtro_doc']) : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $usuarios = User::getFiltered($filtro_usuario, $filtro_rol, $filtro_doc, $orden);
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
        
        // Verificar si el usuario ya existe por número de documento
        $existing_user = User::find($_POST['num_doc']);
        if ($existing_user) {
            $_SESSION['error'] = "Error: Ya existe un usuario con el número de documento {$_POST['num_doc']}.";
            header('Location: ?controller=users&action=create');
            exit;
        }
        
        // Verificar si ya existe un usuario con el mismo nombre de usuario
        $existing_username = User::findByUsername($_POST['usuario']);
        if ($existing_username) {
            $_SESSION['error'] = "Error: Ya existe un usuario con el nombre de usuario '{$_POST['usuario']}'.";
            header('Location: ?controller=users&action=create');
            exit;
        }
        
        $data = [
            'num_doc' => $_POST['num_doc'],
            'tipo_doc' => $_POST['tipo_doc'],
            'usuario' => $_POST['usuario'],
            'rol' => $_POST['rol'],
            'telefono' => $_POST['telefono'],
            'contrasena' => $_POST['contrasena']
        ];
        
        try {
            User::create($data);
            $_SESSION['success'] = "Usuario creado exitosamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al crear el usuario: " . $e->getMessage();
            header('Location: ?controller=users&action=create');
            exit;
        }
        
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
        
        // Verificar si ya existe otro usuario con el mismo nombre de usuario (excluyendo el actual)
        $existing_username = User::findByUsername($_POST['usuario']);
        if ($existing_username && $existing_username['num_doc'] != $num_doc) {
            $_SESSION['error'] = "Error: Ya existe otro usuario con el nombre de usuario '{$_POST['usuario']}'.";
            header("Location: ?controller=users&action=edit&id=$num_doc");
            exit;
        }
        
        $data = [
            'tipo_doc' => $_POST['tipo_doc'],
            'usuario' => $_POST['usuario'],
            'rol' => $_POST['rol'],
            'telefono' => $_POST['telefono'],
            'contrasena' => $_POST['contrasena']
        ];
        
        try {
            User::update($num_doc, $data);
            $_SESSION['success'] = "Usuario actualizado exitosamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al actualizar el usuario: " . $e->getMessage();
            header("Location: ?controller=users&action=edit&id=$num_doc");
            exit;
        }
        
        header('Location: ?controller=users&action=index');
        exit;
    }

    public function delete() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            User::delete($id);
            $_SESSION['success'] = "Usuario eliminado exitosamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al eliminar el usuario: " . $e->getMessage();
        }
        
        header('Location: ?controller=users&action=index');
        exit;
    }
}
