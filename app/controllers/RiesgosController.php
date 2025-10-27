<?php
require_once __DIR__ . '/../models/Riesgo.php';
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../core/Controller.php';

class RiesgosController extends Controller {
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
            header('Location: /RACI/?controller=riesgos&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=riesgos&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $tipo = isset($_GET['filtro_tipo']) ? trim($_GET['filtro_tipo']) : '';
        $condicion = isset($_GET['filtro_condicion']) ? $_GET['filtro_condicion'] : '';
        $riesgos = Riesgo::getFiltered($tipo, $condicion);
        $condiciones = CondicionInsegura::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('riesgos/index', [
            'riesgos' => $riesgos,
            'condiciones' => $condiciones,
            'filtro_tipo' => $tipo,
            'filtro_condicion' => $condicion,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $condiciones = CondicionInsegura::all();
        $this->view('riesgos/create', [
            'condiciones' => $condiciones
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $riesgo = Riesgo::find($id);
        $condiciones = CondicionInsegura::all();
        $this->view('riesgos/edit', [
            'riesgo' => $riesgo,
            'condiciones' => $condiciones
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            Riesgo::delete($id);
            $_SESSION['success'] = 'Riesgo eliminado correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=riesgos&action=index');
        exit;
    }
}
