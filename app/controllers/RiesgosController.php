<?php
require_once __DIR__ . '/../models/Riesgo.php';
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../core/Controller.php';

class RiesgosController extends Controller {
    public function index() {
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $condicion = isset($_GET['filtro_condicion']) ? $_GET['filtro_condicion'] : '';
        $riesgos = Riesgo::getFiltered($tipo, $condicion);
        $condiciones = CondicionInsegura::all();
        $this->view('riesgos/index', [
            'riesgos' => $riesgos,
            'condiciones' => $condiciones,
            'filtro_tipo' => $tipo,
            'filtro_condicion' => $condicion
        ]);
    }
    public function create() {
        $condiciones = CondicionInsegura::all();
        $this->view('riesgos/create', [
            'condiciones' => $condiciones
        ]);
    }
    public function store() {
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'condicion_insegura_id_cond_inseg' => $_POST['condicion_insegura_id_cond_inseg']
        ];
        Riesgo::create($data);
        header('Location: ?controller=riesgos&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $riesgo = Riesgo::find($id);
        $condiciones = CondicionInsegura::all();
        $this->view('riesgos/edit', [
            'riesgo' => $riesgo,
            'condiciones' => $condiciones
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'condicion_insegura_id_cond_inseg' => $_POST['condicion_insegura_id_cond_inseg']
        ];
        Riesgo::update($id, $data);
        header('Location: ?controller=riesgos&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        Riesgo::delete($id);
        header('Location: ?controller=riesgos&action=index');
        exit;
    }
}
