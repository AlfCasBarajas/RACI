<?php
require_once __DIR__ . '/../core/Database.php';

class Rol {
    public static function getFiltered($filtro = '', $orden = '') {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = 'SELECT * FROM rol';
        $params = [];
        if ($filtro !== '') {
            $sql .= ' WHERE nombre LIKE ?';
            $params[] = "%$filtro%";
        }
        if ($orden === 'asc' || $orden === 'desc') {
            $sql .= ' ORDER BY nombre ' . strtoupper($orden);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        return self::getAll();
    }
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
        $db = Database::getConnection();
        
        // Verificar dependencias en tabla user
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM user WHERE rol = ?');
        $stmt->execute([$id]);
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar dependencias en tabla empleado
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM empleado WHERE rol = ?');
        $stmt->execute([$id]);
        $empleados = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $totalDependencias = $users['total'] + $empleados['total'];
        
        if ($totalDependencias > 0) {
            $mensaje = "No se puede eliminar este rol porque está asignado a ";
            $dependencias = [];
            if ($users['total'] > 0) {
                $dependencias[] = "{$users['total']} usuario(s)";
            }
            if ($empleados['total'] > 0) {
                $dependencias[] = "{$empleados['total']} empleado(s)";
            }
            $mensaje .= implode(' y ', $dependencias) . ". Reasigne o elimine primero estos registros.";
            throw new Exception($mensaje);
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM rol WHERE id_Rol = ?');
        return $stmt->execute([$id]);
    }
}
