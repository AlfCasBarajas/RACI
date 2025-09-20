<?php
require_once 'config/database.php';

class User {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT user.*, rol.nombre AS rol_nombre FROM user JOIN rol ON user.rol = rol.id_Rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO user (num_doc, tipo_doc, nombres, apellidos, rol, contrasena, telefono)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['num_doc'],
            $data['tipo_doc'],
            $data['nombres'],
            $data['apellidos'],
            $data['rol'],
            password_hash($data['contrasena'], PASSWORD_BCRYPT),
            $data['telefono']
        ]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM user WHERE num_doc = ?");
        return $stmt->execute([$id]);
    }
}
