<?php
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../core/Controller.php';

class CondicionesInsegurasController extends Controller {
    public function index() {
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'nombre_asc';
        $condiciones = CondicionInsegura::getFiltered($nombre, $orden);
        $this->view('condicionesinseguras/index', [
            'condiciones' => $condiciones,
            'filtro_nombre' => $nombre,
            'filtro_orden' => $orden
        ]);
    }
    public function create() {
        $this->view('condicionesinseguras/create');
    }
    public function store() {
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'lugar' => $_POST['lugar']
        ];
        CondicionInsegura::create($data);
        header('Location: ?controller=condicionesinseguras&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $condicion = CondicionInsegura::find($id);
        $this->view('condicionesinseguras/edit', [
            'condicion' => $condicion
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'lugar' => $_POST['lugar']
        ];
        CondicionInsegura::update($id, $data);
        header('Location: ?controller=condicionesinseguras&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        CondicionInsegura::delete($id);
        header('Location: ?controller=condicionesinseguras&action=index');
        exit;
    }
}
