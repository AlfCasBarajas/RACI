<?php
require_once __DIR__ . '/../core/Database.php';

class Accidente {
    public static function getFilteredWithArea($tipo = '', $fecha_inicio = '', $fecha_fin = '', $area = '', $orden = 'id_asc', $id = '') {
        $db = Database::getConnection();
        $sql = 'SELECT a.*, 
                       COALESCE(ar.nombre, "Sin área asignada") as nombre_area
                FROM accidente a
                LEFT JOIN inspeccion_locativa il ON a.id_accidente = il.accidente_id_accidente
                LEFT JOIN area ar ON il.area_id_area = ar.id_area';
        $where = [];
        $params = [];
        if ($id !== '' && is_numeric($id)) {
            $where[] = 'a.id_accidente = ?';
            $params[] = $id;
        }
        if ($tipo !== '') {
            $where[] = 'a.tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($fecha_inicio !== '' && $fecha_fin !== '') {
            $where[] = 'DATE(a.fecha_hora) BETWEEN ? AND ?';
            $params[] = $fecha_inicio;
            $params[] = $fecha_fin;
        } elseif ($fecha_inicio !== '') {
            $where[] = 'DATE(a.fecha_hora) >= ?';
            $params[] = $fecha_inicio;
        } elseif ($fecha_fin !== '') {
            $where[] = 'DATE(a.fecha_hora) <= ?';
            $params[] = $fecha_fin;
        }
        if ($area !== '') {
            $where[] = 'ar.id_area = ?';
            $params[] = $area;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' GROUP BY a.id_accidente'; // Evitar duplicados si un accidente está en múltiples inspecciones
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY a.tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY a.tipo DESC';
                break;
            case 'area_asc':
                $sql .= ' ORDER BY nombre_area ASC';
                break;
            case 'area_desc':
                $sql .= ' ORDER BY nombre_area DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY a.id_accidente DESC';
                break;
            default:
                $sql .= ' ORDER BY a.id_accidente ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFiltered($tipo = '', $fecha_inicio = '', $fecha_fin = '', $orden = 'id_asc', $id = '') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM accidente';
        $where = [];
        $params = [];
        if ($id !== '' && is_numeric($id)) {
            $where[] = 'id_accidente = ?';
            $params[] = $id;
        }
        if ($tipo !== '') {
            $where[] = 'tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($fecha_inicio !== '' && $fecha_fin !== '') {
            $where[] = 'DATE(fecha_hora) BETWEEN ? AND ?';
            $params[] = $fecha_inicio;
            $params[] = $fecha_fin;
        } elseif ($fecha_inicio !== '') {
            $where[] = 'DATE(fecha_hora) >= ?';
            $params[] = $fecha_inicio;
        } elseif ($fecha_fin !== '') {
            $where[] = 'DATE(fecha_hora) <= ?';
            $params[] = $fecha_fin;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY tipo DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY id_accidente DESC';
                break;
            default:
                $sql .= ' ORDER BY id_accidente ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM accidente');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM accidente WHERE id_accidente = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO accidente (tipo, descripcion, clasificacion, estado, fecha_hora, lugar, tipo_vinc_lab_, jornada_laboral, turno_mom_acc, uso_epp, consecuencias, gravedad, tipo_lesion, parte_cuerpo_afect, incapacidad_lab, aten_med_recibida, persona_informo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['tipo'], $data['descripcion'], $data['clasificacion'], $data['estado'], $data['fecha_hora'], $data['lugar'], $data['tipo_vinc_lab_'], $data['jornada_laboral'], $data['turno_mom_acc'], $data['uso_epp'], $data['consecuencias'], $data['gravedad'], $data['tipo_lesion'], $data['parte_cuerpo_afect'], $data['incapacidad_lab'], $data['aten_med_recibida'], $data['persona_informo']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE accidente SET tipo=?, descripcion=?, clasificacion=?, estado=?, fecha_hora=?, lugar=?, tipo_vinc_lab_=?, jornada_laboral=?, turno_mom_acc=?, uso_epp=?, consecuencias=?, gravedad=?, tipo_lesion=?, parte_cuerpo_afect=?, incapacidad_lab=?, aten_med_recibida=?, persona_informo=? WHERE id_accidente=?');
        $stmt->execute([
            $data['tipo'], $data['descripcion'], $data['clasificacion'], $data['estado'], $data['fecha_hora'], $data['lugar'], $data['tipo_vinc_lab_'], $data['jornada_laboral'], $data['turno_mom_acc'], $data['uso_epp'], $data['consecuencias'], $data['gravedad'], $data['tipo_lesion'], $data['parte_cuerpo_afect'], $data['incapacidad_lab'], $data['aten_med_recibida'], $data['persona_informo'], $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        
        // Verificar dependencias en tabla inspeccion_locativa
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM inspeccion_locativa WHERE accidente_id_accidente = ?');
        $stmt->execute([$id]);
        $inspecciones = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inspecciones['total'] > 0) {
            throw new Exception("No se puede eliminar este accidente porque está vinculado a {$inspecciones['total']} inspección(es) locativa(s). Reasigne o elimine primero estos registros.");
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM accidente WHERE id_accidente = ?');
        $stmt->execute([$id]);
    }
}
