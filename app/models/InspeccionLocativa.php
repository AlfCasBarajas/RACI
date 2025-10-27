<?php
require_once __DIR__ . '/../core/Database.php';

class InspeccionLocativa {
    public static function getFiltered($id = '', $tipo_inspeccion = '', $fecha_hora = '', $estado_inspeccion = '', $categoria = '', $incidente = '', $accidente = '', $riesgo = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT il.*, c.nombre AS categoria_nombre, inc.tipo AS incidente_tipo, acc.tipo AS accidente_tipo, r.tipo AS riesgo_tipo, e.nombres AS empleado_nombres, e.apellidos AS empleado_apellidos, ar.nombre AS area_nombre FROM inspeccion_locativa il'
             . ' LEFT JOIN categoria c ON il.categoria_id_categoria = c.id_categoria'
             . ' LEFT JOIN incidente inc ON il.incidente_id_incidente = inc.id_incidente'
             . ' LEFT JOIN accidente acc ON il.accidente_id_accidente = acc.id_accidente'
             . ' LEFT JOIN riesgo r ON il.riesgo_id_riesgo = r.id_riesgo'
             . ' LEFT JOIN empleado e ON il.empleado_id_empleado = e.id_empleado'
             . ' LEFT JOIN area ar ON il.area_id_area = ar.id_area';
        $where = [];
        $params = [];
        if ($id !== '' && is_numeric($id)) {
            $where[] = 'il.id_insp_loc = ?';
            $params[] = $id;
        }
        if ($tipo_inspeccion !== '') {
            $where[] = 'il.tipo_inspeccion LIKE ?';
            $params[] = "%$tipo_inspeccion%";
        }
        if ($fecha_hora !== '') {
            $where[] = 'DATE(il.fecha_hora) = ?';
            $params[] = $fecha_hora;
        }
        if ($estado_inspeccion !== '') {
            $where[] = 'il.estado_inspeccion LIKE ?';
            $params[] = "%$estado_inspeccion%";
        }
        if ($categoria !== '') {
            $where[] = 'il.categoria_id_categoria = ?';
            $params[] = $categoria;
        }
        if ($incidente !== '') {
            $where[] = 'il.incidente_id_incidente = ?';
            $params[] = $incidente;
        }
        if ($accidente !== '') {
            $where[] = 'il.accidente_id_accidente = ?';
            $params[] = $accidente;
        }
        if ($riesgo !== '') {
            $where[] = 'il.riesgo_id_riesgo = ?';
            $params[] = $riesgo;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'fecha_asc':
                $sql .= ' ORDER BY il.fecha_hora ASC';
                break;
            case 'fecha_desc':
                $sql .= ' ORDER BY il.fecha_hora DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY il.id_insp_loc DESC';
                break;
            default:
                $sql .= ' ORDER BY il.id_insp_loc ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT il.*, c.nombre AS categoria_nombre, inc.tipo AS incidente_tipo, acc.tipo AS accidente_tipo, r.tipo AS riesgo_tipo, e.nombres AS empleado_nombres, e.apellidos AS empleado_apellidos, ar.nombre AS area_nombre FROM inspeccion_locativa il'
            . ' LEFT JOIN categoria c ON il.categoria_id_categoria = c.id_categoria'
            . ' LEFT JOIN incidente inc ON il.incidente_id_incidente = inc.id_incidente'
            . ' LEFT JOIN accidente acc ON il.accidente_id_accidente = acc.id_accidente'
            . ' LEFT JOIN riesgo r ON il.riesgo_id_riesgo = r.id_riesgo'
            . ' LEFT JOIN empleado e ON il.empleado_id_empleado = e.id_empleado'
            . ' LEFT JOIN area ar ON il.area_id_area = ar.id_area');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT il.*, c.nombre AS categoria_nombre, inc.tipo AS incidente_tipo, acc.tipo AS accidente_tipo, r.tipo AS riesgo_tipo, e.nombres AS empleado_nombres, e.apellidos AS empleado_apellidos, ar.nombre AS area_nombre FROM inspeccion_locativa il'
            . ' LEFT JOIN categoria c ON il.categoria_id_categoria = c.id_categoria'
            . ' LEFT JOIN incidente inc ON il.incidente_id_incidente = inc.id_incidente'
            . ' LEFT JOIN accidente acc ON il.accidente_id_accidente = acc.id_accidente'
            . ' LEFT JOIN riesgo r ON il.riesgo_id_riesgo = r.id_riesgo'
            . ' LEFT JOIN empleado e ON il.empleado_id_empleado = e.id_empleado'
            . ' LEFT JOIN area ar ON il.area_id_area = ar.id_area WHERE il.id_insp_loc = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        // Validar campos obligatorios
        if (empty($data['tipo_inspeccion'])) {
            throw new Exception('El tipo de inspección es obligatorio');
        }
        if (empty($data['fecha_hora'])) {
            throw new Exception('La fecha y hora es obligatoria');
        }
        if (empty($data['descripcion'])) {
            throw new Exception('La descripción es obligatoria');
        }
        if (empty($data['estado_inspeccion'])) {
            throw new Exception('El estado de inspección es obligatorio');
        }
        if (empty($data['element_trab'])) {
            throw new Exception('Los elementos de trabajo son obligatorios');
        }
        if (empty($data['observaciones'])) {
            throw new Exception('Las observaciones son obligatorias');
        }
        if (empty($data['categoria_id_categoria'])) {
            throw new Exception('La categoría es obligatoria');
        }
        if (empty($data['area_id_area'])) {
            throw new Exception('El área es obligatoria');
        }
        
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, descripcion, estado_inspeccion, element_trab, observaciones, categoria_id_categoria, empleado_id_empleado, area_id_area, incidente_id_incidente, accidente_id_accidente, riesgo_id_riesgo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['tipo_inspeccion'], 
            $data['fecha_hora'], 
            $data['descripcion'], 
            $data['estado_inspeccion'], 
            $data['element_trab'], 
            $data['observaciones'], 
            $data['categoria_id_categoria'], // Obligatorio
            !empty($data['empleado_id_empleado']) ? $data['empleado_id_empleado'] : null, // Opcional
            $data['area_id_area'], // Obligatorio
            !empty($data['incidente_id_incidente']) ? $data['incidente_id_incidente'] : null,
            !empty($data['accidente_id_accidente']) ? $data['accidente_id_accidente'] : null,
            !empty($data['riesgo_id_riesgo']) ? $data['riesgo_id_riesgo'] : null
        ]);
    }
    public static function update($id, $data) {
        // Validar campos obligatorios
        if (empty($data['tipo_inspeccion'])) {
            throw new Exception('El tipo de inspección es obligatorio');
        }
        if (empty($data['fecha_hora'])) {
            throw new Exception('La fecha y hora es obligatoria');
        }
        if (empty($data['descripcion'])) {
            throw new Exception('La descripción es obligatoria');
        }
        if (empty($data['estado_inspeccion'])) {
            throw new Exception('El estado de inspección es obligatorio');
        }
        if (empty($data['element_trab'])) {
            throw new Exception('Los elementos de trabajo son obligatorios');
        }
        if (empty($data['observaciones'])) {
            throw new Exception('Las observaciones son obligatorias');
        }
        if (empty($data['categoria_id_categoria'])) {
            throw new Exception('La categoría es obligatoria');
        }
        if (empty($data['area_id_area'])) {
            throw new Exception('El área es obligatoria');
        }
        
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE inspeccion_locativa SET tipo_inspeccion=?, fecha_hora=?, descripcion=?, estado_inspeccion=?, element_trab=?, observaciones=?, categoria_id_categoria=?, empleado_id_empleado=?, area_id_area=?, incidente_id_incidente=?, accidente_id_accidente=?, riesgo_id_riesgo=? WHERE id_insp_loc=?');
        $stmt->execute([
            $data['tipo_inspeccion'], 
            $data['fecha_hora'], 
            $data['descripcion'], 
            $data['estado_inspeccion'], 
            $data['element_trab'], 
            $data['observaciones'], 
            $data['categoria_id_categoria'], // Obligatorio
            !empty($data['empleado_id_empleado']) ? $data['empleado_id_empleado'] : null, // Opcional
            $data['area_id_area'], // Obligatorio
            !empty($data['incidente_id_incidente']) ? $data['incidente_id_incidente'] : null,
            !empty($data['accidente_id_accidente']) ? $data['accidente_id_accidente'] : null,
            !empty($data['riesgo_id_riesgo']) ? $data['riesgo_id_riesgo'] : null,
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM inspeccion_locativa WHERE id_insp_loc = ?');
        $stmt->execute([$id]);
    }
}
