<?php
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

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
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $empleados = Empleado::getFiltered($tipo_doc, $nombre, $rol, $area, $orden);
        $roles = Rol::all();
        $areas = Area::all();
        
        // Obtener el rol del usuario actual
    $userRole = $_SESSION['user']['rol'];
    $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
    $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
    $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
    $this->view('empleados/index', ['empleados' => $empleados, 'roles' => $roles, 'areas' => $areas, 'isCoordinador' => $isCoordinador, 'isSupervisor' => $isSupervisor, 'isTrabajador' => $isTrabajador]);
    }

    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $roles = Rol::all();
        $areas = Area::all();
        $this->view('empleados/create', ['roles' => $roles, 'areas' => $areas]);
    }

    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Verificar si el empleado ya existe por ID
        $existing_empleado = Empleado::find($_POST['id_empleado']);
        if ($existing_empleado) {
            $_SESSION['error'] = "Error: Ya existe un empleado con el ID {$_POST['id_empleado']}.";
            header('Location: ?controller=empleados&action=create');
            exit;
        }
        
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
            'rol' => $_POST['rol'],
            'area_id_area' => $_POST['area_id_area']
        ];
        
        try {
            Empleado::create($data);
            $_SESSION['success'] = "Empleado creado exitosamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al crear el empleado: " . $e->getMessage();
            header('Location: ?controller=empleados&action=create');
            exit;
        }
        
        header('Location: ?controller=empleados&action=index');
        exit;
    }

    public function edit() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $empleado = Empleado::find($id);
        $roles = Rol::all();
        $areas = Area::all();
        $this->view('empleados/edit', ['empleado' => $empleado, 'roles' => $roles, 'areas' => $areas]);
    }

    public function update() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        $data = [
            'id_empleado' => $id, // Mantener el ID original ya que el campo es readonly
            'tipo_doc' => $_POST['tipo_doc'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'eps' => $_POST['eps'],
            'arl' => $_POST['arl'],
            'cargo_funcion' => $_POST['cargo_funcion'],
            'antig_cargo' => $_POST['antig_cargo'],
            'rol' => $_POST['rol'],
            'area_id_area' => $_POST['area_id_area']
        ];
        
        try {
            Empleado::update($id, $data);
            $_SESSION['success'] = "Empleado actualizado exitosamente.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al actualizar el empleado: " . $e->getMessage();
            header("Location: ?controller=empleados&action=edit&id=$id");
            exit;
        }
        
        header('Location: ?controller=empleados&action=index');
        exit;
    }

    public function delete() {
        $this->checkNotCoordinadorForEdit();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            Empleado::delete($id);
            $_SESSION['success'] = 'Empleado eliminado correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=empleados&action=index');
        exit;
    }
}
