<?php
// Script de prueba para verificar dependencias de empleado
require_once 'app/core/Database.php';

echo "Probando verificación de dependencias de empleados...\n\n";

try {
    $db = Database::getConnection();
    
    // Verificar si hay empleados
    $stmt = $db->query('SELECT COUNT(*) as total FROM empleado');
    $empleados = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total empleados: {$empleados['total']}\n";
    
    // Verificar dependencias de un empleado específico (usar ID de ejemplo)
    $stmt = $db->query('SELECT id_empleado FROM empleado LIMIT 1');
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($empleado) {
        $id = $empleado['id_empleado'];
        echo "Verificando empleado ID: $id\n";
        
        // Verificar categorías
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM categoria WHERE empleado_id_empleado = ?');
        $stmt->execute([$id]);
        $categorias = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Categorías vinculadas: {$categorias['total']}\n";
        
        // Verificar inspecciones locativas
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM inspeccion_locativa WHERE empleado_id_empleado = ?');
        $stmt->execute([$id]);
        $inspecciones = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Inspecciones locativas vinculadas: {$inspecciones['total']}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>