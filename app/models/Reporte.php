<?php
require_once __DIR__ . '/../core/Database.php';

class Reporte {
    public static function getFiltered($id = '', $nombre = '', $orden = 'id_asc') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM reporte';
        $where = [];
        $params = [];
        if ($id !== '' && is_numeric($id)) {
            $where[] = 'id_reporte = ?';
            $params[] = $id;
        }
        if ($nombre !== '') {
            $where[] = 'nombre LIKE ?';
            $params[] = "%$nombre%";
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        switch ($orden) {
            case 'nombre_asc':
                $sql .= ' ORDER BY nombre ASC';
                break;
            case 'nombre_desc':
                $sql .= ' ORDER BY nombre DESC';
                break;
            case 'id_desc':
                $sql .= ' ORDER BY id_reporte DESC';
                break;
            default:
                $sql .= ' ORDER BY id_reporte ASC';
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM reporte');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM reporte WHERE id_reporte = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO reporte (nombre) VALUES (?)');
        $stmt->execute([$data['nombre']]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE reporte SET nombre=? WHERE id_reporte=?');
        $stmt->execute([$data['nombre'], $id]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM reporte WHERE id_reporte = ?');
        $stmt->execute([$id]);
    }
}
