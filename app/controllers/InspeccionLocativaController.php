<?php
require_once __DIR__ . '/../models/InspeccionLocativa.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../models/Riesgo.php';
require_once __DIR__ . '/../core/Controller.php';

class InspeccionLocativaController extends Controller {
    public function index() {
        $id = isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '';
        $tipo_inspeccion = isset($_GET['filtro_tipo_inspeccion']) ? trim($_GET['filtro_tipo_inspeccion']) : '';
        $fecha_hora = isset($_GET['filtro_fecha_hora']) ? $_GET['filtro_fecha_hora'] : '';
        $estado_inspeccion = isset($_GET['filtro_estado_inspeccion']) ? trim($_GET['filtro_estado_inspeccion']) : '';
        $categoria = isset($_GET['filtro_categoria']) ? trim($_GET['filtro_categoria']) : '';
        $incidente = isset($_GET['filtro_incidente']) ? trim($_GET['filtro_incidente']) : '';
        $accidente = isset($_GET['filtro_accidente']) ? trim($_GET['filtro_accidente']) : '';
        $riesgo = isset($_GET['filtro_riesgo']) ? trim($_GET['filtro_riesgo']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $inspecciones = InspeccionLocativa::getFiltered($id, $tipo_inspeccion, $fecha_hora, $estado_inspeccion, $categoria, $incidente, $accidente, $riesgo, $orden);
        $this->view('inspeccioneslocativas/index', [
            'inspecciones' => $inspecciones,
            'filtro_id' => $id,
            'filtro_tipo_inspeccion' => $tipo_inspeccion,
            'filtro_fecha_hora' => $fecha_hora,
            'filtro_estado_inspeccion' => $estado_inspeccion,
            'filtro_categoria' => $categoria,
            'filtro_incidente' => $incidente,
            'filtro_accidente' => $accidente,
            'filtro_riesgo' => $riesgo,
            'filtro_orden' => $orden
        ]);
    }
    public function create() {
        $categorias = Categoria::all();
        $incidentes = Incidente::all();
        $accidentes = Accidente::all();
        $riesgos = Riesgo::all();
        $this->view('inspeccioneslocativas/create', [
            'categorias' => $categorias,
            'incidentes' => $incidentes,
            'accidentes' => $accidentes,
            'riesgos' => $riesgos
        ]);
    }
    public function store() {
        $data = [
            'tipo_inspeccion' => $_POST['tipo_inspeccion'],
            'fecha_hora' => $_POST['fecha_hora'],
            'descripcion' => $_POST['descripcion'],
            'estado_inspeccion' => $_POST['estado_inspeccion'],
            'element_trab' => $_POST['element_trab'],
            'observaciones' => $_POST['observaciones'],
            'categoria_id_categoria' => $_POST['categoria_id_categoria'],
            'incidente_id_incidente' => $_POST['incidente_id_incidente'],
            'accidente_id_accidente' => $_POST['accidente_id_accidente'],
            'riesgo_id_riesgo' => $_POST['riesgo_id_riesgo']
        ];
        InspeccionLocativa::create($data);
        header('Location: ?controller=inspeccionlocativa&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $inspeccion = InspeccionLocativa::find($id);
        $categorias = Categoria::all();
        $incidentes = Incidente::all();
        $accidentes = Accidente::all();
        $riesgos = Riesgo::all();
        $this->view('inspeccioneslocativas/edit', [
            'inspeccion' => $inspeccion,
            'categorias' => $categorias,
            'incidentes' => $incidentes,
            'accidentes' => $accidentes,
            'riesgos' => $riesgos
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'tipo_inspeccion' => $_POST['tipo_inspeccion'],
            'fecha_hora' => $_POST['fecha_hora'],
            'act_economica' => $_POST['act_economica'],
            'descripcion' => $_POST['descripcion'],
            'estado_inspeccion' => $_POST['estado_inspeccion'],
            'element_trab' => $_POST['element_trab'],
            'observaciones' => $_POST['observaciones'],
            'categoria_id_categoria' => $_POST['categoria_id_categoria'],
            'incidente_id_incidente' => $_POST['incidente_id_incidente'],
            'accidente_id_accidente' => $_POST['accidente_id_accidente'],
            'riesgo_id_riesgo' => $_POST['riesgo_id_riesgo']
        ];
        InspeccionLocativa::update($id, $data);
        header('Location: ?controller=inspeccionlocativa&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        InspeccionLocativa::delete($id);
        header('Location: ?controller=inspeccionlocativa&action=index');
        exit;
    }
}
