<?php
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../core/Controller.php';

class CategoriasController extends Controller {
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
            header('Location: /RACI/?controller=categorias&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=categorias&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $usuario = isset($_GET['filtro_usuario']) ? $_GET['filtro_usuario'] : '';
        $empleado = isset($_GET['filtro_empleado']) ? $_GET['filtro_empleado'] : '';
        $descripcion = isset($_GET['filtro_descripcion']) ? trim($_GET['filtro_descripcion']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'nombre_asc';
        $categorias = Categoria::getFiltered($nombre, $area, $usuario, $empleado, $descripcion, $orden);
        $areas = Area::all();
        $usuarios = User::all();
        $empleados = Empleado::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('categorias/index', [
            'categorias' => $categorias,
            'areas' => $areas,
            'usuarios' => $usuarios,
            'empleados' => $empleados,
            'filtro_descripcion' => $descripcion,
            'filtro_orden' => $orden,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }

    public function create() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        $areas = Area::all();
        $usuarios = User::all();
        $empleados = Empleado::all();
        $this->view('categorias/create', [
            'areas' => $areas,
            'usuarios' => $usuarios,
            'empleados' => $empleados
        ]);
    }

    public function store() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'area_id_area' => $_POST['area_id_area'],
            'user_num_doc' => $_POST['user_num_doc'],
            'empleado_id_empleado' => $_POST['empleado_id_empleado']
        ];
        Categoria::create($data);
        header('Location: ?controller=categorias&action=index');
        exit;
    }

    public function edit() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $categoria = Categoria::find($id);
        $areas = Area::all();
        $usuarios = User::all();
        $empleados = Empleado::all();
        $this->view('categorias/edit', [
            'categoria' => $categoria,
            'areas' => $areas,
            'usuarios' => $usuarios,
            'empleados' => $empleados
        ]);
    }

    public function update() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'area_id_area' => $_POST['area_id_area'],
            'user_num_doc' => $_POST['user_num_doc'],
            'empleado_id_empleado' => $_POST['empleado_id_empleado']
        ];
        Categoria::update($id, $data);
        header('Location: ?controller=categorias&action=index');
        exit;
    }

    public function delete() {
        $this->checkNotCoordinador();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            Categoria::delete($id);
            $_SESSION['success'] = 'Categoría eliminada correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=categorias&action=index');
        exit;
    }
}
