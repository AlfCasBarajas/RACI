<?php
require_once __DIR__ . '/../core/Database.php';

class CondicionInsegura {
    public static function getFiltered($descripcion = '', $nombre = '', $orden = 'nombre_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM condicion_insegura';
        $where = [];
        $params = [];
        if ($descripcion !== '') {
            $where[] = 'descripcion LIKE ?';
            $params[] = "%$descripcion%";
        }
        if ($nombre !== '') {
            $where[] = 'nombre LIKE ?';
            $params[] = "%$nombre%";
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        // Ordenamiento
        switch ($orden) {
            case 'nombre_desc':
                $sql .= ' ORDER BY nombre DESC';
                break;
            case 'id_asc':
                $sql .= ' ORDER BY id_cond_inseg ASC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY id_cond_inseg DESC';
                break;
            default:
                $sql .= ' ORDER BY nombre ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM condicion_insegura');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM condicion_insegura WHERE id_cond_inseg = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO condicion_insegura (nombre, descripcion, lugar) VALUES (?, ?, ?)');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['lugar']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE condicion_insegura SET nombre=?, descripcion=?, lugar=? WHERE id_cond_inseg=?');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['lugar'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        
        // Verificar dependencias en tabla riesgo
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM riesgo WHERE condicion_insegura_id_cond_inseg = ?');
        $stmt->execute([$id]);
        $riesgos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($riesgos['total'] > 0) {
            throw new Exception("No se puede eliminar esta condición insegura porque está vinculada a {$riesgos['total']} riesgo(s). Reasigne o elimine primero estos registros.");
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM condicion_insegura WHERE id_cond_inseg = ?');
        return $stmt->execute([$id]);
    }
}
