<?php
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';

class AreasController extends Controller {
    public function index() {
        $filtro_nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : '';
        $areas = Area::getFiltered($filtro_nombre, $orden);
        $this->view('areas/index', ['areas' => $areas]);
    }

    public function create() {
        $this->view('areas/create');
    }

    public function store() {
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion']
        ];
        Area::create($data);
        header('Location: ?controller=areas&action=index');
        exit;
    }

    public function edit() {
        $id = $_GET['id'];
        $area = Area::find($id);
        $this->view('areas/edit', ['area' => $area]);
    }

    public function update() {
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion']
        ];
        Area::update($id, $data);
        header('Location: ?controller=areas&action=index');
        exit;
    }

    public function delete() {
        $id = $_GET['id'];
        Area::delete($id);
        header('Location: ?controller=areas&action=index');
        exit;
    }
}
