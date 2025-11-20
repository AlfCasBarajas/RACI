<?php
require_once __DIR__ . '/../models/CondicionInsegura.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

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
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'nombre_asc';
        $condiciones = CondicionInsegura::getFilteredWithArea('', $nombre, $area, $orden);
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
        // Obtener el rol del usuario actual
        $userRole = $_SESSION['user']['rol'];
        $isCoordinador = ($userRole == 3); // 3 es el ID del rol coordinador
        $isSupervisor = ($userRole == 2); // 2 es el ID del rol supervisor
        $isTrabajador = ($userRole == 4); // 4 es el ID del rol trabajador
        $this->view('condicionesinseguras/index', [
            'condiciones' => $condiciones,
            'filtro_nombre' => $nombre,
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
        $this->view('condicionesinseguras/create', [
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=condicionesinseguras&action=create&error=area_required');
            exit;
        }
        
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'lugar' => $_POST['lugar']
        ];
        
        // Crear la condición insegura
        $condicionCreated = CondicionInsegura::create($data);
        
        $db = Database::getConnection();
        // Obtener el ID de la condición recién creada
        $condicionId = $db->lastInsertId();
        
        // Crear riesgo automático para vincular condición con área
        $stmt = $db->prepare('INSERT INTO riesgo (tipo, descripcion, condicion_insegura_id_cond_inseg) VALUES (?, ?, ?)');
        $stmt->execute([
            'Riesgo automático',
            'Riesgo creado automáticamente para vincular condición insegura con área',
            $condicionId
        ]);
        
        $riesgoId = $db->lastInsertId();
        
        // Crear inspección locativa para vincular riesgo con área
        $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, riesgo_id_riesgo, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            'Vinculación automática',
            date('Y-m-d H:i:s'),
            'Inspección creada automáticamente para vincular condición insegura con área',
            'Pendiente',
            $riesgoId,
            $_POST['area_id']
        ]);
        
        header('Location: ?controller=condicionesinseguras&action=index');
        exit;
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $condicion = CondicionInsegura::find($id);
        $areas = Area::all();
        
        // Obtener área actual de la condición insegura si existe
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT il.area_id_area FROM riesgo r 
                             LEFT JOIN inspeccion_locativa il ON r.id_riesgo = il.riesgo_id_riesgo 
                             WHERE r.condicion_insegura_id_cond_inseg = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccion = $stmt->fetch(PDO::FETCH_ASSOC);
        $areaActual = $inspeccion ? $inspeccion['area_id_area'] : null;
        
        $this->view('condicionesinseguras/edit', [
            'condicion' => $condicion,
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
            header('Location: ?controller=condicionesinseguras&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'lugar' => $_POST['lugar']
        ];
        
        // Actualizar la condición insegura
        CondicionInsegura::update($id, $data);
        
        // Manejar la relación con área a través de riesgo e inspección locativa
        $db = Database::getConnection();
        
        // Verificar si ya existe un riesgo para esta condición
        $stmt = $db->prepare('SELECT r.id_riesgo FROM riesgo r WHERE r.condicion_insegura_id_cond_inseg = ? LIMIT 1');
        $stmt->execute([$id]);
        $riesgoExistente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($riesgoExistente) {
            $riesgoId = $riesgoExistente['id_riesgo'];
            
            // Verificar si ya existe inspección locativa para este riesgo
            $stmt = $db->prepare('SELECT id_insp_loc FROM inspeccion_locativa WHERE riesgo_id_riesgo = ? LIMIT 1');
            $stmt->execute([$riesgoId]);
            $inspeccionExistente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($inspeccionExistente) {
                // Actualizar inspección existente
                $stmt = $db->prepare('UPDATE inspeccion_locativa SET area_id_area = ?, fecha_hora = ? WHERE riesgo_id_riesgo = ?');
                $stmt->execute([$_POST['area_id'], date('Y-m-d H:i:s'), $riesgoId]);
            } else {
                // Crear nueva inspección locativa
                $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, riesgo_id_riesgo, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([
                    'Vinculación automática',
                    date('Y-m-d H:i:s'),
                    'Inspección creada automáticamente para vincular condición insegura con área',
                    'Pendiente',
                    $riesgoId,
                    $_POST['area_id']
                ]);
            }
        } else {
            // Crear nuevo riesgo e inspección locativa
            $stmt = $db->prepare('INSERT INTO riesgo (tipo, descripcion, condicion_insegura_id_cond_inseg) VALUES (?, ?, ?)');
            $stmt->execute([
                'Riesgo automático',
                'Riesgo creado automáticamente para vincular condición insegura con área',
                $id
            ]);
            
            $riesgoId = $db->lastInsertId();
            
            $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, riesgo_id_riesgo, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                'Vinculación automática',
                date('Y-m-d H:i:s'),
                'Inspección creada automáticamente para vincular condición insegura con área',
                'Pendiente',
                $riesgoId,
                $_POST['area_id']
            ]);
        }
        
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
