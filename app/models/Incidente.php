<?php
require_once __DIR__ . '/../core/Database.php';

class Incidente {
    public static function getFilteredWithArea($tipo = '', $fecha_inicio = '', $fecha_fin = '', $area = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT i.*, 
                       COALESCE(a.nombre, "Sin área asignada") as nombre_area
                FROM incidente i
                LEFT JOIN inspeccion_locativa il ON i.id_incidente = il.incidente_id_incidente
                LEFT JOIN area a ON il.area_id_area = a.id_area';
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
        if ($area !== '') {
            $where[] = 'a.id_area = ?';
            $params[] = $area;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' GROUP BY i.id_incidente'; // Evitar duplicados si un incidente está en múltiples inspecciones
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
        $stmt = $db->prepare('INSERT INTO incidente (tipo, descripcion, fecha_hora, lugar) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['fecha'],
            $data['lugar']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE incidente SET tipo=?, descripcion=?, fecha_hora=?, lugar=? WHERE id_incidente=?');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['fecha'],
            $data['lugar'],
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
            throw new Exception("No se puede eliminar este incidente porque está vinculado a {$inspecciones['total']} inspección(es) locativa(s). Reasigne o elimine primero estos registros.");
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM incidente WHERE id_incidente = ?');
        return $stmt->execute([$id]);
    }
}
