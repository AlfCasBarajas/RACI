<?php
require_once __DIR__ . '/../core/Database.php';

class Categoria {
    public static function getFiltered($nombre = '', $area = '', $usuario = '', $empleado = '', $descripcion = '', $orden = 'nombre_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT c.*, a.nombre as area_nombre, u.nombres as usuario_nombre, e.nombres as empleado_nombre FROM categoria c '
            . 'LEFT JOIN area a ON c.area_id_area = a.id_area '
            . 'LEFT JOIN user u ON c.user_num_doc = u.num_doc '
            . 'LEFT JOIN empleado e ON c.empleado_id_empleado = e.id_empleado';
        $where = [];
        $params = [];
        if ($nombre !== '') {
            $where[] = 'c.nombre LIKE ?';
            $params[] = "%$nombre%";
        }
        if ($area !== '') {
            $where[] = 'c.area_id_area = ?';
            $params[] = $area;
        }
        if ($usuario !== '') {
            $where[] = 'c.user_num_doc = ?';
            $params[] = $usuario;
        }
        if ($empleado !== '') {
            $where[] = 'c.empleado_id_empleado = ?';
            $params[] = $empleado;
        }
        if ($descripcion !== '') {
            $where[] = 'c.descripcion LIKE ?';
            $params[] = "%$descripcion%";
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        // Ordenamiento
        switch ($orden) {
            case 'nombre_desc':
                $sql .= ' ORDER BY c.nombre DESC';
                break;
            case 'id_asc':
                $sql .= ' ORDER BY c.id_categoria ASC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY c.id_categoria DESC';
                break;
            default:
                $sql .= ' ORDER BY c.nombre ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM categoria');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM categoria WHERE id_categoria = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO categoria (nombre, descripcion, area_id_area, user_num_doc, empleado_id_empleado) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['area_id_area'],
            $data['user_num_doc'],
            $data['empleado_id_empleado']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE categoria SET nombre=?, descripcion=?, area_id_area=?, user_num_doc=?, empleado_id_empleado=? WHERE id_categoria=?');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['area_id_area'],
            $data['user_num_doc'],
            $data['empleado_id_empleado'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM categoria WHERE id_categoria = ?');
        return $stmt->execute([$id]);
    }
}
