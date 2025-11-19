<?php
require_once __DIR__ . '/app/core/Database.php';

$db = Database::getConnection();

echo "=== DATOS EN TABLA condicion_insegura ===" . PHP_EOL;

try {
    $stmt = $db->query("SELECT * FROM condicion_insegura ORDER BY id_cond_inseg");
    $condiciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($condiciones)) {
        echo "❌ La tabla está vacía" . PHP_EOL;
    } else {
        echo "✅ Encontrados " . count($condiciones) . " registros:" . PHP_EOL . PHP_EOL;
        
        foreach ($condiciones as $condicion) {
            echo "ID: " . $condicion['id_cond_inseg'] . PHP_EOL;
            echo "Nombre: " . $condicion['nombre'] . PHP_EOL;
            echo "Descripción: " . ($condicion['descripcion'] ?? 'Sin descripción') . PHP_EOL;
            echo "Lugar: " . ($condicion['lugar'] ?? 'Sin lugar') . PHP_EOL;
            echo "---" . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Probando el modelo CondicionInsegura ===" . PHP_EOL;

require_once __DIR__ . '/app/models/CondicionInsegura.php';

try {
    $condicionesModelo = CondicionInsegura::getFiltered('', '');
    echo "✅ Modelo devuelve " . count($condicionesModelo) . " registros" . PHP_EOL;
    
    if (!empty($condicionesModelo)) {
        echo "Primer registro del modelo:" . PHP_EOL;
        print_r($condicionesModelo[0]);
    }
} catch (Exception $e) {
    echo "❌ ERROR en modelo: " . $e->getMessage() . PHP_EOL;
}
?>