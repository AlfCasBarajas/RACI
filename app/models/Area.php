<?php
require_once __DIR__ . '/../core/Database.php';

class Area {
    public static function getFiltered($filtro_nombre = '', $orden = '') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM area';
        $params = [];
        if ($filtro_nombre !== '') {
            $sql .= ' WHERE nombre LIKE ?';
            $params[] = "%$filtro_nombre%";
        }
        if ($orden === 'asc' || $orden === 'desc') {
            $sql .= ' ORDER BY nombre ' . strtoupper($orden);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM area');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM area WHERE id_area = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO area (nombre, descripcion) VALUES (?, ?)');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE area SET nombre=?, descripcion=? WHERE id_area=?');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM area WHERE id_area = ?');
        return $stmt->execute([$id]);
    }
}
