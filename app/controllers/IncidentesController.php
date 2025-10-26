<?php
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../core/Controller.php';

class IncidentesController extends Controller {
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
            header('Location: /RACI/?controller=incidentes&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=incidentes&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $fecha = isset($_GET['filtro_fecha']) ? $_GET['filtro_fecha'] : '';
        $lugar = isset($_GET['filtro_lugar']) ? trim($_GET['filtro_lugar']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $incidentes = Incidente::getFiltered($tipo, $fecha, $lugar, $orden);
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('incidentes/index', [
            'incidentes' => $incidentes,
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
        $this->view('incidentes/create');
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $incidente = Incidente::find($id);
        $this->view('incidentes/edit', [
            'incidente' => $incidente
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        Incidente::delete($id);
        header('Location: ?controller=incidentes&action=index');
        exit;
    }
}
