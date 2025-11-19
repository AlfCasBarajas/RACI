<?php
require_once __DIR__ . '/app/core/Database.php';

$db = Database::getConnection();

$tablas = ['area', 'empleado', 'categoria', 'condicion_insegura', 'riesgo', 'incidente', 'accidente', 'inspeccion_locativa'];

echo "=== VERIFICACIÓN DE TABLAS RACI ===" . PHP_EOL;
echo "Fecha: " . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;

foreach ($tablas as $tabla) {
    try {
        $stmt = $db->query("SELECT COUNT(*) as total FROM $tabla");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $resultado['total'];
        
        echo sprintf("%-20s: %s registros", $tabla, $total);
        if ($total == 0) {
            echo " ❌ VACÍA";
        } else {
            echo " ✅ CON DATOS";
        }
        echo PHP_EOL;
    } catch (Exception $e) {
        echo sprintf("%-20s: ERROR - %s", $tabla, $e->getMessage()) . PHP_EOL;
    }
}

echo PHP_EOL . "=== FIN VERIFICACIÓN ===" . PHP_EOL;
?>