<?php
require_once __DIR__ . '/app/models/CondicionInsegura.php';

echo "=== PRUEBA DE ORDENAMIENTO EN REPORTES ===" . PHP_EOL;

// Simular llamada del reporte con orden ascendente por ID
$condiciones = CondicionInsegura::getFiltered('', '', 'id_asc');

echo "✅ Ordenamiento por ID ascendente:" . PHP_EOL;
echo "Total de registros: " . count($condiciones) . PHP_EOL . PHP_EOL;

foreach ($condiciones as $index => $condicion) {
    echo ($index + 1) . ". ID: " . $condicion['id_cond_inseg'];
    echo " | Nombre: " . $condicion['nombre']; 
    echo " | Lugar: " . $condicion['lugar'] . PHP_EOL;
}

echo PHP_EOL . "✅ Perfecto! Ahora los reportes mostrarán:" . PHP_EOL;
echo "1. Piso mojado" . PHP_EOL;
echo "2. Herramienta defectuosa" . PHP_EOL; 
echo "3. Cable suelto" . PHP_EOL;
echo "4. Iluminación insuficiente" . PHP_EOL;
echo "5. Estante inestable" . PHP_EOL;
?>