<?php
require_once __DIR__ . '/../models/Accidente.php';
require_once __DIR__ . '/../models/Area.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

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
        $area = isset($_GET['filtro_area']) ? $_GET['filtro_area'] : '';
        $orden = isset($_GET['filtro_orden']) ? $_GET['filtro_orden'] : 'id_asc';
        $accidentes = Accidente::getFilteredWithArea($tipo, $fecha, $lugar, $area, $orden, $id);
        
        // Obtener todas las áreas para el filtro
        $areas = Area::all();
        
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
        $this->view('accidentes/create', [
            'areas' => $areas
        ]);
    }
    public function store() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        
        // Validar que se haya seleccionado un área
        if (!isset($_POST['area_id']) || empty($_POST['area_id'])) {
            header('Location: ?controller=accidentes&action=create&error=area_required');
            exit;
        }
        
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
        
        // Crear el accidente
        $accidenteCreated = Accidente::create($data);
        
        // Crear inspección locativa para vincular accidente con área (ahora siempre obligatorio)
        $db = Database::getConnection();
        // Obtener el ID del accidente recién creado
        $accidenteId = $db->lastInsertId();
        
        // Crear inspección locativa para vincular accidente con área
        $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, accidente_id_accidente, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            'Vinculación automática',
            $_POST['fecha_hora'],
            'Inspección creada automáticamente para vincular accidente con área',
            'Pendiente',
            $accidenteId,
            $_POST['area_id']
        ]);
        
        header('Location: ?controller=accidentes&action=index');
        exit;
    }
    public function edit() {
        $this->onlyLogged();
        $this->checkNotTrabajador();
        $id = $_GET['id'];
        $accidente = Accidente::find($id);
        $areas = Area::all();
        
        // Obtener área actual del accidente si existe
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT area_id_area FROM inspeccion_locativa WHERE accidente_id_accidente = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccion = $stmt->fetch(PDO::FETCH_ASSOC);
        $areaActual = $inspeccion ? $inspeccion['area_id_area'] : null;
        
        $this->view('accidentes/edit', [
            'accidente' => $accidente,
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
            header('Location: ?controller=accidentes&action=edit&id=' . $id . '&error=area_required');
            exit;
        }
        
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
        
        // Actualizar el accidente
        Accidente::update($id, $data);
        
        // Manejar la relación con área a través de inspección locativa
        $db = Database::getConnection();
        
        // Verificar si ya existe una inspección locativa para este accidente
        $stmt = $db->prepare('SELECT id_insp_loc FROM inspeccion_locativa WHERE accidente_id_accidente = ? LIMIT 1');
        $stmt->execute([$id]);
        $inspeccionExistente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inspeccionExistente) {
            // Actualizar inspección existente
            $stmt = $db->prepare('UPDATE inspeccion_locativa SET area_id_area = ?, fecha_hora = ? WHERE accidente_id_accidente = ?');
            $stmt->execute([$_POST['area_id'], $_POST['fecha_hora'], $id]);
        } else {
            // Crear nueva inspección locativa
            $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, accidente_id_accidente, area_id_area) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                'Vinculación automática',
                $_POST['fecha_hora'],
                'Inspección creada automáticamente para vincular accidente con área',
                'Pendiente',
                $id,
                $_POST['area_id']
            ]);
        }
        
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
