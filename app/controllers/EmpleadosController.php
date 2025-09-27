<?php
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../core/Controller.php';

class EmpleadosController extends Controller {
    public function index() {
        $tipo_doc = isset($_GET['filtro_tipo_doc']) ? trim($_GET['filtro_tipo_doc']) : '';
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $rol = isset($_GET['filtro_rol']) ? $_GET['filtro_rol'] : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $empleados = Empleado::getFiltered($tipo_doc, $nombre, $rol, $orden);
        $roles = Rol::all();
        $this->view('empleados/index', ['empleados' => $empleados, 'roles' => $roles]);
    }

    public function create() {
        $roles = Rol::all();
        $this->view('empleados/create', ['roles' => $roles]);
    }

    public function store() {
        $data = [
            'id_empleado' => $_POST['id_empleado'],
            'tipo_doc' => $_POST['tipo_doc'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'eps' => $_POST['eps'],
            'arl' => $_POST['arl'],
            'cargo_funcion' => $_POST['cargo_funcion'],
            'antig_cargo' => $_POST['antig_cargo'],
            'rol' => $_POST['rol']
        ];
        Empleado::create($data);
        header('Location: ?controller=empleados&action=index');
        exit;
    }

    public function edit() {
        $id = $_GET['id'];
        $empleado = Empleado::find($id);
        $roles = Rol::all();
        $this->view('empleados/edit', ['empleado' => $empleado, 'roles' => $roles]);
    }

    public function update() {
        $id = $_GET['id'];
        $data = [
            'id_empleado' => $_POST['id_empleado'],
            'tipo_doc' => $_POST['tipo_doc'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'eps' => $_POST['eps'],
            'arl' => $_POST['arl'],
            'cargo_funcion' => $_POST['cargo_funcion'],
            'antig_cargo' => $_POST['antig_cargo'],
            'rol' => $_POST['rol']
        ];
        Empleado::update($id, $data);
        header('Location: ?controller=empleados&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'];
        Empleado::delete($id);
        header('Location: ?controller=empleados&action=index');
        exit;
    }
}
