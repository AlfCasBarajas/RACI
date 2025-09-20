<?php
require_once __DIR__ . '/../core/Database.php';

class CondicionInsegura {
    public static function getFiltered($nombre = '', $orden = 'nombre_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM condicion_insegura';
        $where = [];
        $params = [];
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
        $stmt = $db->prepare('DELETE FROM condicion_insegura WHERE id_cond_inseg = ?');
        return $stmt->execute([$id]);
    }
}
