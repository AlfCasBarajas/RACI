<?php
require_once __DIR__ . '/../core/Database.php';

class InspeccionLocativa {
    public static function getFiltered($id = '', $tipo_inspeccion = '', $fecha_hora = '', $estado_inspeccion = '', $categoria = '', $incidente = '', $accidente = '', $riesgo = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM inspeccion_locativa';
        $where = [];
        $params = [];
        if ($id !== '' && is_numeric($id)) {
            $where[] = 'id_insp_loc = ?';
            $params[] = $id;
        }
        if ($tipo_inspeccion !== '') {
            $where[] = 'tipo_inspeccion LIKE ?';
            $params[] = "%$tipo_inspeccion%";
        }
        if ($fecha_hora !== '') {
            $where[] = 'DATE(fecha_hora) = ?';
            $params[] = $fecha_hora;
        }
        if ($estado_inspeccion !== '') {
            $where[] = 'estado_inspeccion LIKE ?';
            $params[] = "%$estado_inspeccion%";
        }
        if ($categoria !== '') {
            $where[] = 'categoria_id_categoria = ?';
            $params[] = $categoria;
        }
        if ($incidente !== '') {
            $where[] = 'incidente_id_incidente = ?';
            $params[] = $incidente;
        }
        if ($accidente !== '') {
            $where[] = 'accidente_id_accidente = ?';
            $params[] = $accidente;
        }
        if ($riesgo !== '') {
            $where[] = 'riesgo_id_riesgo = ?';
            $params[] = $riesgo;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'fecha_asc':
                $sql .= ' ORDER BY fecha_hora ASC';
                break;
            case 'fecha_desc':
                $sql .= ' ORDER BY fecha_hora DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY id_insp_loc DESC';
                break;
            default:
                $sql .= ' ORDER BY id_insp_loc ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM inspeccion_locativa');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM inspeccion_locativa WHERE id_insp_loc = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO inspeccion_locativa (tipo_inspeccion, fecha_hora, act_economica, descripcion, estado_inspeccion, element_trab, observaciones, categoria_id_categoria, incidente_id_incidente, accidente_id_accidente, riesgo_id_riesgo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['tipo_inspeccion'], $data['fecha_hora'], $data['act_economica'], $data['descripcion'], $data['estado_inspeccion'], $data['element_trab'], $data['observaciones'], $data['categoria_id_categoria'], $data['incidente_id_incidente'], $data['accidente_id_accidente'], $data['riesgo_id_riesgo']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE inspeccion_locativa SET tipo_inspeccion=?, fecha_hora=?, act_economica=?, descripcion=?, estado_inspeccion=?, element_trab=?, observaciones=?, categoria_id_categoria=?, incidente_id_incidente=?, accidente_id_accidente=?, riesgo_id_riesgo=? WHERE id_insp_loc=?');
        $stmt->execute([
            $data['tipo_inspeccion'], $data['fecha_hora'], $data['act_economica'], $data['descripcion'], $data['estado_inspeccion'], $data['element_trab'], $data['observaciones'], $data['categoria_id_categoria'], $data['incidente_id_incidente'], $data['accidente_id_accidente'], $data['riesgo_id_riesgo'], $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM inspeccion_locativa WHERE id_insp_loc = ?');
        $stmt->execute([$id]);
    }
}
