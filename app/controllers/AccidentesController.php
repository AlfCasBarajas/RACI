<?php
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../core/Controller.php';

class AccidentesController extends Controller {
    public function index() {
        $id = isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '';
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $fecha = isset($_GET['filtro_fecha']) ? $_GET['filtro_fecha'] : '';
        $lugar = isset($_GET['filtro_lugar']) ? trim($_GET['filtro_lugar']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $accidentes = Accidente::getFiltered($tipo, $fecha, $lugar, $orden, $id);
        $this->view('accidentes/index', [
            'accidentes' => $accidentes,
            'filtro_id' => $id,
            'filtro_tipo' => $tipo,
            'filtro_fecha' => $fecha,
            'filtro_lugar' => $lugar,
            'filtro_orden' => $orden
        ]);
    }
    public function create() {
        $this->view('accidentes/create');
    }
    public function store() {
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'clasificacion' => $_POST['clasificacion'],
            'estado' => $_POST['estado'],
            'fecha_hora' => $_POST['fecha_hora'],
            'lugar' => $_POST['lugar'],
            'tipo_vinc_lab_' => $_POST['tipo_vinc_lab_'],
            'jornada_laboral' => $_POST['jornada_laboral'],
            'turno_mom_acc' => $_POST['turno_mom_acc'],
            'uso_epp' => $_POST['uso_epp'],
            'consecuencias' => $_POST['consecuencias'],
            'gravedad' => $_POST['gravedad'],
            'tipo_lesion' => $_POST['tipo_lesion'],
            'parte_cuerpo_afect' => $_POST['parte_cuerpo_afect'],
            'incapacidad_lab' => $_POST['incapacidad_lab'],
            'aten_med_recibida' => $_POST['aten_med_recibida'],
            'persona_informo' => $_POST['persona_informo']
        ];
        Accidente::create($data);
        header('Location: ?controller=accidentes&action=index');
        exit;
    }
    public function edit() {
        $id = $_GET['id'];
        $accidente = Accidente::find($id);
        $this->view('accidentes/edit', [
            'accidente' => $accidente
        ]);
    }
    public function update() {
        $id = $_GET['id'];
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'clasificacion' => $_POST['clasificacion'],
            'estado' => $_POST['estado'],
            'fecha_hora' => $_POST['fecha_hora'],
            'lugar' => $_POST['lugar'],
            'tipo_vinc_lab_' => $_POST['tipo_vinc_lab_'],
            'jornada_laboral' => $_POST['jornada_laboral'],
            'turno_mom_acc' => $_POST['turno_mom_acc'],
            'uso_epp' => $_POST['uso_epp'],
            'consecuencias' => $_POST['consecuencias'],
            'gravedad' => $_POST['gravedad'],
            'tipo_lesion' => $_POST['tipo_lesion'],
            'parte_cuerpo_afect' => $_POST['parte_cuerpo_afect'],
            'incapacidad_lab' => $_POST['incapacidad_lab'],
            'aten_med_recibida' => $_POST['aten_med_recibida'],
            'persona_informo' => $_POST['persona_informo']
        ];
        Accidente::update($id, $data);
        header('Location: ?controller=accidentes&action=index');
        exit;
    }
    public function delete() {
        $id = $_GET['id'];
        Accidente::delete($id);
        header('Location: ?controller=accidentes&action=index');
        exit;
    }
}
