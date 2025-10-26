<?php
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../core/Controller.php';

class EmpleadosController extends Controller {
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
            header('Location: /RACI/?controller=empleados&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=empleados&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $tipo_doc = isset($_GET['filtro_tipo_doc']) ? trim($_GET['filtro_tipo_doc']) : '';
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $rol = isset($_GET['filtro_rol']) ? $_GET['filtro_rol'] : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $empleados = Empleado::getFiltered($tipo_doc, $nombre, $rol, $orden);
        $roles = Rol::all();
        
        // Obtener el rol del usuario actual
    $userRole = $_SESSION['user']['rol'];
    $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
    $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
    $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
    $this->view('empleados/index', ['empleados' => $empleados, 'roles' => $roles, 'isCoordinador' => $isCoordinador, 'isSupervisor' => $isSupervisor, 'isTrabajador' => $isTrabajador]);
    }

    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $roles = Rol::all();
        $this->view('empleados/create', ['roles' => $roles]);
    }

    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $empleado = Empleado::find($id);
        $roles = Rol::all();
        $this->view('empleados/edit', ['empleado' => $empleado, 'roles' => $roles]);
    }

    public function update() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
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
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        Empleado::delete($id);
        header('Location: ?controller=empleados&action=index');
        exit;
    }
}
