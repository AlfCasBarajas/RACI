<?php
require_once __DIR__ . '/../core/Database.php';

class Incidente {
    public static function getFilteredWithArea($tipo = '', $fecha_inicio = '', $fecha_fin = '', $lugar = '', $area = '', $empleado = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT i.*, 
                       COALESCE(a.nombre, "Sin área asignada") as nombre_area,
                       COALESCE(CONCAT(e.nombres, " ", e.apellidos), "Sin empleado asignado") as nombre_empleado
                FROM incidente i
                LEFT JOIN area a ON i.area_id_area = a.id_area
                LEFT JOIN empleado e ON i.empleado_id_empleado = e.id_empleado';
        $where = [];
        $params = [];
        if ($tipo !== '') {
            $where[] = 'i.tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($fecha_inicio !== '' && $fecha_fin !== '') {
            $where[] = 'DATE(i.fecha_hora) BETWEEN ? AND ?';
            $params[] = $fecha_inicio;
            $params[] = $fecha_fin;
        } elseif ($fecha_inicio !== '') {
            $where[] = 'DATE(i.fecha_hora) >= ?';
            $params[] = $fecha_inicio;
        } elseif ($fecha_fin !== '') {
            $where[] = 'DATE(i.fecha_hora) <= ?';
            $params[] = $fecha_fin;
        }
        if ($lugar !== '') {
            $where[] = 'i.lugar LIKE ?';
            $params[] = "%$lugar%";
        }
        if ($area !== '') {
            $where[] = 'i.area_id_area = ?';
            $params[] = $area;
        }
        if ($empleado !== '') {
            $where[] = 'i.empleado_id_empleado = ?';
            $params[] = $empleado;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY i.tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY i.tipo DESC';
                break;
            case 'area_asc':
                $sql .= ' ORDER BY nombre_area ASC';
                break;
            case 'area_desc':
                $sql .= ' ORDER BY nombre_area DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY i.id_incidente DESC';
                break;
            default:
                $sql .= ' ORDER BY i.id_incidente ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFiltered($tipo = '', $fecha_inicio = '', $fecha_fin = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT i.* FROM incidente i';
        $where = [];
        $params = [];
        if ($tipo !== '') {
            $where[] = 'i.tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($fecha_inicio !== '' && $fecha_fin !== '') {
            $where[] = 'DATE(i.fecha_hora) BETWEEN ? AND ?';
            $params[] = $fecha_inicio;
            $params[] = $fecha_fin;
        } elseif ($fecha_inicio !== '') {
            $where[] = 'DATE(i.fecha_hora) >= ?';
            $params[] = $fecha_inicio;
        } elseif ($fecha_fin !== '') {
            $where[] = 'DATE(i.fecha_hora) <= ?';
            $params[] = $fecha_fin;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY i.tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY i.tipo DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY i.id_incidente DESC';
                break;
            default:
                $sql .= ' ORDER BY i.id_incidente ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM incidente');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM incidente WHERE id_incidente = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO incidente (tipo, descripcion, fecha_hora, lugar, tipo_vinc_lab, jornada_laboral, turno_mom_inc, uso_epp, area_id_area, empleado_id_empleado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['fecha'],
            $data['lugar'],
            $data['tipo_vinc_lab'],
            $data['jornada_laboral'],
            $data['turno_mom_inc'],
            $data['uso_epp'],
            $data['area_id'],
            $data['empleado_id']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE incidente SET tipo=?, descripcion=?, fecha_hora=?, lugar=?, tipo_vinc_lab=?, jornada_laboral=?, turno_mom_inc=?, uso_epp=?, area_id_area=?, empleado_id_empleado=? WHERE id_incidente=?');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['fecha'],
            $data['lugar'],
            $data['tipo_vinc_lab'],
            $data['jornada_laboral'],
            $data['turno_mom_inc'],
            $data['uso_epp'],
            $data['area_id'],
            $data['empleado_id'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        
        // Verificar dependencias en tabla inspeccion_locativa
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM inspeccion_locativa WHERE incidente_id_incidente = ?');
        $stmt->execute([$id]);
        $inspecciones = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inspecciones['total'] > 0) {
            throw new Exception("No se puede eliminar este incidente porque está referenciado en {$inspecciones['total']} inspección(es) locativa(s). Elimine primero las referencias en inspecciones locativas.");
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM incidente WHERE id_incidente = ?');
        return $stmt->execute([$id]);
    }
}
