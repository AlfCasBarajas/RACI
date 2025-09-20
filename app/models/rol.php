<?php
require_once 'config/database.php';

class Rol {
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM rol WHERE id_Rol = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
