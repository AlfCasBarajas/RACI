<?php
require_once __DIR__ . '/../models/Reporte.php';
require_once __DIR__ . '/../core/Controller.php';

class ReportesController extends Controller {
    public function index() {
        $id = isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '';
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $reportes = Reporte::getFiltered($id, $nombre, $orden);
        $this->view('reportes/index', [
            'reportes' => $reportes,
            'filtro_id' => $id,
            'filtro_nombre' => $nombre,
            'filtro_orden' => $orden
        ]);
    }
    public function create() {
        $this->view('reportes/create');
    }
    public function store() {
        $data = [
            'nombre' => $_POST['nombre']
        ];
        Reporte::create($data);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $reporte = Reporte::find($id);
        $this->view('reportes/edit', [
            'reporte' => $reporte
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'nombre' => $_POST['nombre']
        ];
        Reporte::update($id, $data);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        Reporte::delete($id);
        header('Location: ?controller=reportes&action=index');
        exit;
    }
}
