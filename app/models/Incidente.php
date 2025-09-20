<?php
require_once __DIR__ . '/../core/Database.php';

class Incidente {
    public static function getFiltered($tipo = '', $fecha = '', $lugar = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM incidente';
        $where = [];
        $params = [];
        if ($tipo !== '') {
            $where[] = 'tipo LIKE ?';
            $params[] = "%$tipo%";
        }
        if ($fecha !== '') {
            $where[] = 'DATE(fecha_hora) = ?';
            $params[] = $fecha;
        }
        if ($lugar !== '') {
            $where[] = 'lugar LIKE ?';
            $params[] = "%$lugar%";
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'tipo_asc':
                $sql .= ' ORDER BY tipo ASC';
                break;
            case 'tipo_desc':
                $sql .= ' ORDER BY tipo DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY id_incidente DESC';
                break;
            default:
                $sql .= ' ORDER BY id_incidente ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM incidente');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM incidente WHERE id_incidente = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO incidente (tipo, descripcion, fecha_hora, lugar) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['fecha'],
            $data['lugar']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE incidente SET tipo=?, descripcion=?, fecha_hora=?, lugar=? WHERE id_incidente=?');
        return $stmt->execute([
            $data['tipo'],
            $data['descripcion'],
            $data['fecha'],
            $data['lugar'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM incidente WHERE id_incidente = ?');
        return $stmt->execute([$id]);
    }
}
