<?php
require_once __DIR__ . '/../core/Database.php';

class Area {
    public static function getFiltered($filtro_nombre = '', $orden = '') {
        $db = Database::getConnection();
        $sql = 'SELECT * FROM area';
        $params = [];
        if ($filtro_nombre !== '') {
            $sql .= ' WHERE nombre LIKE ?';
            $params[] = "%$filtro_nombre%";
        }
        if ($orden === 'asc' || $orden === 'desc') {
            $sql .= ' ORDER BY nombre ' . strtoupper($orden);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM area');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM area WHERE id_area = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO area (nombre, descripcion) VALUES (?, ?)');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion']
        ]);
    }
    public static function update($id, $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE area SET nombre=?, descripcion=? WHERE id_area=?');
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $id
        ]);
    }
    public static function delete($id) {
        $db = Database::getConnection();
        
        // Verificar todas las dependencias
        $dependencias = [];
        
        // Verificar categorías
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM categoria WHERE area_id_area = ?');
        $stmt->execute([$id]);
        $categorias = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($categorias['total'] > 0) {
            $dependencias[] = "{$categorias['total']} categoría(s)";
        }
        
        // Verificar incidentes
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM incidente WHERE area_id_area = ?');
        $stmt->execute([$id]);
        $incidentes = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($incidentes['total'] > 0) {
            $dependencias[] = "{$incidentes['total']} incidente(s)";
        }
        
        // Verificar accidentes
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM accidente WHERE area_id_area = ?');
        $stmt->execute([$id]);
        $accidentes = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($accidentes['total'] > 0) {
            $dependencias[] = "{$accidentes['total']} accidente(s)";
        }
        
        // Verificar condiciones inseguras
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM condicion_insegura WHERE area_id_area = ?');
        $stmt->execute([$id]);
        $condiciones = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($condiciones['total'] > 0) {
            $dependencias[] = "{$condiciones['total']} condición(es) insegura(s)";
        }
        
        // Verificar riesgos
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM riesgo WHERE area_id_area = ?');
        $stmt->execute([$id]);
        $riesgos = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($riesgos['total'] > 0) {
            $dependencias[] = "{$riesgos['total']} riesgo(s)";
        }
        
        // Verificar inspecciones locativas
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM inspeccion_locativa WHERE area_id_area = ?');
        $stmt->execute([$id]);
        $inspecciones = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($inspecciones['total'] > 0) {
            $dependencias[] = "{$inspecciones['total']} inspección(es) locativa(s)";
        }
        
        // Si hay dependencias, mostrar mensaje elegante
        if (!empty($dependencias)) {
            if (count($dependencias) == 1) {
                $mensaje = "Esta área no se puede eliminar porque tiene {$dependencias[0]} asociado(s).";
            } elseif (count($dependencias) == 2) {
                $mensaje = "Esta área no se puede eliminar porque tiene {$dependencias[0]} y {$dependencias[1]} asociados.";
            } else {
                $ultimaDependencia = array_pop($dependencias);
                $mensaje = "Esta área no se puede eliminar porque tiene " . implode(', ', $dependencias) . " y {$ultimaDependencia} asociados.";
            }
            $mensaje .= "\n\nPara poder eliminar esta área, primero debe reasignar o eliminar todos los registros asociados.";
            throw new Exception($mensaje);
        }
        
        // Si no hay dependencias, proceder con la eliminación
        $stmt = $db->prepare('DELETE FROM area WHERE id_area = ?');
        return $stmt->execute([$id]);
    }
}
