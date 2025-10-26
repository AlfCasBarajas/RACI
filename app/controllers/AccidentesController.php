<?php
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../core/Controller.php';

class AccidentesController extends Controller {
    private function onlyLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: /RACI/?controller=login&action=index');
            exit;
        }
    }

    private function checkNotCoordinadorForDelete() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 3) { // 3 es el ID del rol coordinador
            header('Location: /RACI/?controller=accidentes&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=accidentes&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $id = isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '';
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $fecha = isset($_GET['filtro_fecha']) ? $_GET['filtro_fecha'] : '';
        $lugar = isset($_GET['filtro_lugar']) ? trim($_GET['filtro_lugar']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $accidentes = Accidente::getFiltered($tipo, $fecha, $lugar, $orden, $id);
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('accidentes/index', [
            'accidentes' => $accidentes,
            'filtro_id' => $id,
            'filtro_tipo' => $tipo,
            'filtro_fecha' => $fecha,
            'filtro_lugar' => $lugar,
            'filtro_orden' => $orden,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $this->view('accidentes/create');
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $accidente = Accidente::find($id);
        $this->view('accidentes/edit', [
            'accidente' => $accidente
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        Accidente::delete($id);
        header('Location: ?controller=accidentes&action=index');
        exit;
    }
}
