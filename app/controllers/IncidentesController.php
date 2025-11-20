<?php
require_once __DIR__ . '/../models/Incidente.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

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
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $incidentes = Incidente::getFilteredWithArea($tipo, $fecha, $lugar, $area, $orden);
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
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
            'filtro_area' => $area,
            'filtro_orden' => $orden,
            'areas' => $areas,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $areas = Area::all();
        $this->view('incidentes/create', [
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=incidentes&action=create&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha'],
            'lugar' => $_POST['lugar']
        ];
        
        // Crear el incidente
        $incidenteCreated = Incidente::create($data);
        
        // Crear inspección locativa para vincular incidente con área (ahora siempre obligatorio)
        $db = Database::getConnection();
        // Obtener el ID del incidente recién creado
        $incidenteId = $db->lastInsertId();
        
        // Crear inspección locativa para vincular incidente con área
        $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, incidente_id_incidente, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            'Vinculación automática',
            $_POST['fecha'] . ' 00:00:00',
            'Inspección creada automáticamente para vincular incidente con área',
            'Pendiente',
            $incidenteId,
            $_POST['area_id']
        ]);
        
        header('Location: ?controller=incidentes&action=index');
        exit;
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $incidente = Incidente::find($id);
        $areas = Area::all();
        
        // Obtener área actual del incidente si existe
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT area_id_area FROM inspeccion_locativa WHERE incidente_id_incidente = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccion = $stmt->fetch(PDO::FETCH_ASSOC);
        $areaActual = $inspeccion ? $inspeccion['area_id_area'] : null;
        
        $this->view('incidentes/edit', [
            'incidente' => $incidente,
            'areas' => $areas,
            'area_actual' => $areaActual
        ]);
    }
    public function update() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=incidentes&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha'],
            'lugar' => $_POST['lugar']
        ];
        
        // Actualizar el incidente
        Incidente::update($id, $data);
        
        // Manejar la relación con área a través de inspección locativa
        $db = Database::getConnection();
        
        // Verificar si ya existe una inspección locativa para este incidente
        $stmt = $db->prepare('SELECT id_insp_loc FROM inspeccion_locativa WHERE incidente_id_incidente = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccionExistente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inspeccionExistente) {
            // Actualizar inspección existente
            $stmt = $db->prepare('UPDATE inspeccion_locativa SET area_id_area = ?, fecha_hora = ? WHERE incidente_id_incidente = ?');
            $stmt->execute([$_POST['area_id'], $_POST['fecha'] . ' 00:00:00', $id]);
        } else {
            // Crear nueva inspección locativa
            $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, incidente_id_incidente, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                'Vinculación automática',
                $_POST['fecha'] . ' 00:00:00',
                'Inspección creada automáticamente para vincular incidente con área',
                'Pendiente',
                $id,
                $_POST['area_id']
            ]);
        }
        
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
