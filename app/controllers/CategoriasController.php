<?php
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../core/Controller.php';

class CategoriasController extends Controller {
    public function index() {
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
        $this->view('categorias/index', [
            'categorias' => $categorias,
            'areas' => $areas,
            'usuarios' => $usuarios,
            'empleados' => $empleados,
            'filtro_descripcion' => $descripcion,
            'filtro_orden' => $orden
        ]);
    }

    public function create() {
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
        $id = $_GET['id'];
        Categoria::delete($id);
        header('Location: ?controller=categorias&action=index');
        exit;
    }
}
