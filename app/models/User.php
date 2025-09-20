<?php
// app/models/User.php
require_once __DIR__ . '/../core/Database.php';

class User {
    public static function getFiltered($filtro_doc = '', $filtro_nombre = '', $filtro_rol = '', $orden = '') {
        $db = Database::getConnection();
        $sql = 'SELECT u.*, r.nombre as rol_nombre FROM user u JOIN rol r ON u.rol = r.id_Rol';
        $where = [];
        $params = [];
        if ($filtro_doc !== '') {
            $where[] = 'u.num_doc LIKE ?';
            $params[] = "%$filtro_doc%";
        }
        if ($filtro_nombre !== '') {
            $where[] = 'u.nombres LIKE ?';
            $params[] = "%$filtro_nombre%";
        }
        if ($filtro_rol !== '') {
            $where[] = 'u.rol = ?';
            $params[] = $filtro_rol;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $ordenes = ['num_doc' => 'u.num_doc', 'nombres' => 'u.nombres', 'rol' => 'r.nombre'];
        if ($orden && isset($ordenes[$orden])) {
            $sql .= ' ORDER BY ' . $ordenes[$orden] . ' ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT u.*, r.nombre as rol_nombre FROM user u JOIN rol r ON u.rol = r.id_Rol');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($num_doc) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM user WHERE num_doc = ?');
        $stmt->execute([$num_doc]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO user (num_doc, tipo_doc, nombres, apellidos, rol, contrasena, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $hashed = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        return $stmt->execute([
            $data['num_doc'],
            $data['tipo_doc'],
            $data['nombres'],
            $data['apellidos'],
            $data['rol'],
            $hashed,
            $data['telefono']
        ]);
    }

    public static function update($num_doc, $data) {
        $db = Database::getConnection();
        if (!empty($data['contrasena'])) {
            $hashed = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            $stmt = $db->prepare('UPDATE user SET tipo_doc=?, nombres=?, apellidos=?, rol=?, contrasena=?, telefono=? WHERE num_doc=?');
            return $stmt->execute([
                $data['tipo_doc'],
                $data['nombres'],
                $data['apellidos'],
                $data['rol'],
                $hashed,
                $data['telefono'],
                $num_doc
            ]);
        } else {
            $stmt = $db->prepare('UPDATE user SET tipo_doc=?, nombres=?, apellidos=?, rol=?, telefono=? WHERE num_doc=?');
            return $stmt->execute([
                $data['tipo_doc'],
                $data['nombres'],
                $data['apellidos'],
                $data['rol'],
                $data['telefono'],
                $num_doc
            ]);
        }
    }

    public static function delete($num_doc) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM user WHERE num_doc = ?');
        return $stmt->execute([$num_doc]);
    }
}
