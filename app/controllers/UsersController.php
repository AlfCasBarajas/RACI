<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../core/Controller.php';

class UsersController extends Controller {
    public function index() {
        $filtro_doc = isset($_GET['filtro_doc']) ? trim($_GET['filtro_doc']) : '';
        $filtro_nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $filtro_rol = isset($_GET['filtro_rol']) ? $_GET['filtro_rol'] : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $usuarios = User::getFiltered($filtro_doc, $filtro_nombre, $filtro_rol, $orden);
        $roles = Rol::all();
        $this->view('users/index', ['usuarios' => $usuarios, 'roles' => $roles]);
    }

    public function create() {
        $roles = Rol::all();
        $this->view('users/create', ['roles' => $roles]);
    }

    public function store() {
        $data = [
            'num_doc' => $_POST['num_doc'],
            'tipo_doc' => $_POST['tipo_doc'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'rol' => $_POST['rol'],
            'telefono' => $_POST['telefono'],
            'contrasena' => $_POST['contrasena']
        ];
        User::create($data);
        header('Location: ?controller=users&action=index');
        exit;
    }

    public function edit() {
        $num_doc = $_GET['id'];
        $usuario = User::find($num_doc);
        $roles = Rol::all();
        $this->view('users/edit', ['usuario' => $usuario, 'roles' => $roles]);
    }

    public function update() {
        $num_doc = $_GET['id'];
        $data = [
            'tipo_doc' => $_POST['tipo_doc'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'rol' => $_POST['rol'],
            'telefono' => $_POST['telefono'],
            'contrasena' => $_POST['contrasena']
        ];
        User::update($num_doc, $data);
        header('Location: ?controller=users&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'];
        User::delete($id);
        header('Location: ?controller=users&action=index');
        exit;
    }
}
