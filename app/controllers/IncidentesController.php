<?php
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../core/Controller.php';

class IncidentesController extends Controller {
    public function index() {
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $fecha = isset($_GET['filtro_fecha']) ? $_GET['filtro_fecha'] : '';
        $lugar = isset($_GET['filtro_lugar']) ? trim($_GET['filtro_lugar']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $incidentes = Incidente::getFiltered($tipo, $fecha, $lugar, $orden);
        $this->view('incidentes/index', [
            'incidentes' => $incidentes,
            'filtro_tipo' => $tipo,
            'filtro_fecha' => $fecha,
            'filtro_lugar' => $lugar,
            'filtro_orden' => $orden
        ]);
    }
    public function create() {
        $this->view('incidentes/create');
    }
    public function store() {
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha'],
            'lugar' => $_POST['lugar']
        ];
        Incidente::create($data);
        header('Location: ?controller=incidentes&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $incidente = Incidente::find($id);
        $this->view('incidentes/edit', [
            'incidente' => $incidente
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha'],
            'lugar' => $_POST['lugar']
        ];
        Incidente::update($id, $data);
        header('Location: ?controller=incidentes&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        Incidente::delete($id);
        header('Location: ?controller=incidentes&action=index');
        exit;
    }
}
