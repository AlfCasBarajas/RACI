<?php
require_once __DIR__ . '/../models/Riesgo.php';
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

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
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $riesgos = Riesgo::getFilteredWithArea('', $tipo, $condicion, $area, $orden);
        $condiciones = CondicionInsegura::all();
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('riesgos/index', [
            'riesgos' => $riesgos,
            'condiciones' => $condiciones,
            'areas' => $areas,
            'filtro_tipo' => $tipo,
            'filtro_condicion' => $condicion,
            'filtro_area' => $area,
            'filtro_orden' => $orden,
            'isCoordinador' => $isCoordinador,
            'isSupervisor' => $isSupervisor,
            'isTrabajador' => $isTrabajador
        ]);
    }
    public function create() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $condiciones = CondicionInsegura::all();
        $areas = Area::all();
        $this->view('riesgos/create', [
            'condiciones' => $condiciones,
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=riesgos&action=create&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'condicion_insegura_id_cond_inseg' => $_POST['condicion_insegura_id_cond_inseg']
        ];
        
        // Crear el riesgo
        $riesgoCreated = Riesgo::create($data);
        
        $db = Database::getConnection();
        // Obtener el ID del riesgo recién creado
        $riesgoId = $db->lastInsertId();
        
        // Crear inspección locativa para vincular riesgo con área
        $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, riesgo_id_riesgo, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            'Vinculación automática',
            date('Y-m-d H:i:s'),
            'Inspección creada automáticamente para vincular riesgo con área',
            'Pendiente',
            $riesgoId,
            $_POST['area_id']
        ]);
        
        header('Location: ?controller=riesgos&action=index');
        exit;
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $riesgo = Riesgo::find($id);
        $condiciones = CondicionInsegura::all();
        $areas = Area::all();
        
        // Obtener área actual del riesgo si existe
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT area_id_area FROM inspeccion_locativa WHERE riesgo_id_riesgo = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccion = $stmt->fetch(PDO::FETCH_ASSOC);
        $areaActual = $inspeccion ? $inspeccion['area_id_area'] : null;
        
        $this->view('riesgos/edit', [
            'riesgo' => $riesgo,
            'condiciones' => $condiciones,
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
            header('Location: ?controller=riesgos&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'condicion_insegura_id_cond_inseg' => $_POST['condicion_insegura_id_cond_inseg']
        ];
        
        // Actualizar el riesgo
        Riesgo::update($id, $data);
        
        // Manejar la relación con área a través de inspección locativa
        $db = Database::getConnection();
        
        // Verificar si ya existe una inspección locativa para este riesgo
        $stmt = $db->prepare('SELECT id_insp_loc FROM inspeccion_locativa WHERE riesgo_id_riesgo = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccionExistente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inspeccionExistente) {
            // Actualizar inspección existente
            $stmt = $db->prepare('UPDATE inspeccion_locativa SET area_id_area = ?, fecha_hora = ? WHERE riesgo_id_riesgo = ?');
            $stmt->execute([$_POST['area_id'], date('Y-m-d H:i:s'), $id]);
        } else {
            // Crear nueva inspección locativa
            $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, riesgo_id_riesgo, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                'Vinculación automática',
                date('Y-m-d H:i:s'),
                'Inspección creada automáticamente para vincular riesgo con área',
                'Pendiente',
                $id,
                $_POST['area_id']
            ]);
        }
        
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
