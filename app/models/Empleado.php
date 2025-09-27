<?php
require_once __DIR__ . '/../core/Database.php';

class Empleado {
    public static function getFiltered($tipo_doc = '', $nombre = '', $rol = '', $orden = '') {
        $db = Database::getConnection();
        $sql = 'SELECT e.*, r.nombre as rol_nombre FROM empleado e LEFT JOIN rol r ON e.rol = r.id_Rol';
        $where = [];
        $params = [];
        if ($tipo_doc !== '') {
            $where[] = 'e.tipo_doc LIKE ?';
            $params[] = "%$tipo_doc%";
        }
        if ($nombre !== '') {
            $where[] = 'e.nombres LIKE ?';
            $params[] = "%$nombre%";
        }
        if ($rol !== '') {
            $where[] = 'e.rol = ?';
            $params[] = $rol;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $ordenes = ['tipo_doc' => 'e.tipo_doc', 'nombres' => 'e.nombres', 'rol' => 'r.nombre'];
        if ($orden && isset($ordenes[$orden])) {
            $sql .= ' ORDER BY ' . $ordenes[$orden] . ' ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function all() {
        return self::getFiltered();
    }

    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM empleado WHERE id_empleado = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO empleado (id_empleado, tipo_doc, nombres, apellidos, telefono, eps, arl, cargo_funcion, antig_cargo, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([
            $data['id_empleado'],
            $data['tipo_doc'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['eps'],
            $data['arl'],
            $data['cargo_funcion'],
            $data['antig_cargo'],
            $data['rol']
        ]);
    }

    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE empleado SET id_empleado = ?, tipo_doc = ?, nombres = ?, apellidos = ?, telefono = ?, eps = ?, arl = ?, cargo_funcion = ?, antig_cargo = ?, rol = ? WHERE id_empleado = ?');
            return $stmt->execute([
                $data['id_empleado'],
                $data['tipo_doc'],
                $data['nombres'],
                $data['apellidos'],
                $data['telefono'],
                $data['eps'],
                $data['arl'],
                $data['cargo_funcion'],
                $data['antig_cargo'],
                $data['rol'],
                $id
            ]);
    }

    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM empleado WHERE id_empleado = ?');
        return $stmt->execute([$id]);
    }
}
