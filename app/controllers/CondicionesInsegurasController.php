<?php
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../core/Controller.php';

class CondicionesInsegurasController extends Controller {
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
            header('Location: /RACI/?controller=condicionesinseguras&action=index');
            exit;
        }
    }

    private function checkNotTrabajador() {
        $this->onlyLogged();
        if ($_SESSION['user']['rol'] == 4) { // 4 es el ID del rol trabajador
            header('Location: /RACI/?controller=condicionesinseguras&action=index');
            exit;
        }
    }

    public function index() {
        $this->onlyLogged();
        $nombre = isset($_GET['filtro_nombre']) ? trim($_GET['filtro_nombre']) : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'nombre_asc';
        $condiciones = CondicionInsegura::getFiltered('', $nombre, $orden);
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('condicionesinseguras/index', [
            'condiciones' => $condiciones,
            'filtro_nombre' => $nombre,
            'filtro_orden' => $orden,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $this->view('condicionesinseguras/create');
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $condicion = CondicionInsegura::find($id);
        $this->view('condicionesinseguras/edit', [
            'condicion' => $condicion
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
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
        $this->checkNotCoordinadorForDelete();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        try {
            CondicionInsegura::delete($id);
            $_SESSION['success'] = 'Condición insegura eliminada correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: ?controller=condicionesinseguras&action=index');
        exit;
    }
}
