<?php
require_once __DIR__ . '/../core/Database.php';

class Riesgo {
    public static function getFilteredWithArea($descripcion = '', $tipo = '', $condicion = '', $area = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT r.*, c.nombre as condicion_nombre, 
                       COALESCE(a.nombre, "Sin área asignada") as nombre_area
                FROM riesgo r 
                LEFT JOIN condicion_insegura c ON r.condicion_insegura_id_cond_inseg = c.id_cond_inseg
                LEFT JOIN area a ON r.area_id_area = a.id_area';
        $where = [];
        $params = [];
        if ($descripcion !== '') {
            $where[] = 'r.descripcion LIKE ?';
            $params[] = "%$descripcion%";
        }
        if ($tipo !== '') {
            $where[] = 'r.tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($condicion !== '') {
            $where[] = 'r.condicion_insegura_id_cond_inseg = ?';
            $params[] = $condicion;
        }
        if ($area !== '') {
            $where[] = 'r.area_id_area = ?';
            $params[] = $area;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY r.tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY r.tipo DESC';
                break;
            case 'area_asc':
                $sql .= ' ORDER BY nombre_area ASC';
                break;
            case 'area_desc':
                $sql .= ' ORDER BY nombre_area DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY r.id_riesgo DESC';
                break;
            default:
                $sql .= ' ORDER BY r.id_riesgo ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFiltered($descripcion = '', $tipo = '', $condicion = '') {
        $db = Database::getConnection();
        $sql = 'SELECT r.*, c.nombre as condicion_nombre FROM riesgo r LEFT JOIN condicion_insegura c ON r.condicion_insegura_id_cond_inseg = c.id_cond_inseg';
        $where = [];
        $params = [];
        if ($descripcion !== '') {
            $where[] = 'r.descripcion LIKE ?';
            $params[] = "%$descripcion%";
        }
        if ($tipo !== '') {
            $where[] = 'r.tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($condicion !== '') {
            $where[] = 'r.condicion_insegura_id_cond_inseg = ?';
            $params[] = $condicion;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY r.id_riesgo ASC';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM riesgo');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM riesgo WHERE id_riesgo = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO riesgo (tipo, descripcion, condicion_insegura_id_cond_inseg, area_id_area) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['condicion_insegura_id_cond_inseg'],
            $data['area_id']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE riesgo SET tipo=?, descripcion=?, condicion_insegura_id_cond_inseg=?, area_id_area=? WHERE id_riesgo=?');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['condicion_insegura_id_cond_inseg'],
            $data['area_id'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        
        // Verificar dependencias en tabla inspeccion_locativa
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM inspeccion_locativa WHERE riesgo_id_riesgo = ?');
        $stmt->execute([$id]);
        $inspecciones = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inspecciones['total'] > 0) {
            throw new Exception("No se puede eliminar este riesgo porque está referenciado en {$inspecciones['total']} inspección(es) locativa(s). Elimine primero las referencias en inspecciones locativas.");
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM riesgo WHERE id_riesgo = ?');
        return $stmt->execute([$id]);
    }
}
