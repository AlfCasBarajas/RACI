<?php
require_once __DIR__ . '/../core/Database.php';

class Rol {
    public static function getAll() {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->query('SELECT * FROM rol');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('SELECT * FROM rol WHERE id_Rol = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($nombre) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('INSERT INTO rol (nombre) VALUES (?)');
        return $stmt->execute([$nombre]);
    }

    public static function update($id, $nombre) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('UPDATE rol SET nombre = ? WHERE id_Rol = ?');
        return $stmt->execute([$nombre, $id]);
    }

    public static function delete($id) {
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare('DELETE FROM rol WHERE id_Rol = ?');
        return $stmt->execute([$id]);
    }
}
