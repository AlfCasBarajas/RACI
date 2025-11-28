<?php
require_once __DIR__ . '/../core/Database.php';

class Empleado {
    public static function getFiltered($tipo_doc = '', $nombre = '', $rol = '', $area = '', $orden = '') {
        $db = Database::getConnection();
        $sql = 'SELECT e.*, r.nombre as rol_nombre, a.nombre as area_nombre FROM empleado e LEFT JOIN rol r ON e.rol = r.id_Rol LEFT JOIN area a ON e.area_id_area = a.id_area';
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
        if ($area !== '') {
            $where[] = 'e.area_id_area = ?';
            $params[] = $area;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $ordenes = ['tipo_doc' => 'e.tipo_doc', 'nombres' => 'e.nombres', 'rol' => 'r.nombre', 'area' => 'a.nombre'];
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
        
        try {
            $stmt = $db->prepare('INSERT INTO empleado (id_empleado, tipo_doc, nombres, apellidos, telefono, eps, arl, cargo_funcion, antig_cargo, rol, area_id_area) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
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
                $data['area_id_area']
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if (strpos($e->getMessage(), 'PRIMARY') !== false) {
                    throw new Exception("Ya existe un empleado con el ID {$data['id_empleado']}");
                } else {
                    throw new Exception("Error de integridad en la base de datos: " . $e->getMessage());
                }
            }
            throw $e;
        }
    }

    public static function update($id, $data) {
        $db = Database::getConnection();
        
        try {
            $stmt = $db->prepare('UPDATE empleado SET id_empleado = ?, tipo_doc = ?, nombres = ?, apellidos = ?, telefono = ?, eps = ?, arl = ?, cargo_funcion = ?, antig_cargo = ?, rol = ?, area_id_area = ? WHERE id_empleado = ?');
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
                $data['area_id_area'],
                $id
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if (strpos($e->getMessage(), 'PRIMARY') !== false) {
                    throw new Exception("Ya existe un empleado con el ID {$data['id_empleado']}");
                } else {
                    throw new Exception("Error de integridad en la base de datos: " . $e->getMessage());
                }
            }
            throw $e;
        }
    }

    public static function delete($id) {
        $db = Database::getConnection();
        
        // Verificar dependencias en tabla categoria
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM categoria WHERE empleado_id_empleado = ?');
        $stmt->execute([$id]);
        $categorias = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar dependencias en tabla inspeccion_locativa
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM inspeccion_locativa WHERE empleado_id_empleado = ?');
        $stmt->execute([$id]);
        $inspecciones = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $totalDependencias = $categorias['total'] + $inspecciones['total'];
        
        if ($totalDependencias > 0) {
            $mensaje = "No se puede eliminar este empleado porque está vinculado a ";
            $dependencias = [];
            if ($categorias['total'] > 0) {
                $dependencias[] = "{$categorias['total']} categoría(s)";
            }
            if ($inspecciones['total'] > 0) {
                $dependencias[] = "{$inspecciones['total']} inspección(es) locativa(s)";
            }
            $mensaje .= implode(' y ', $dependencias) . ". Reasigne o elimine primero estos registros.";
            throw new Exception($mensaje);
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM empleado WHERE id_empleado = ?');
        return $stmt->execute([$id]);
    }
}
