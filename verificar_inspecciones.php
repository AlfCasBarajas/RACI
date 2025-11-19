<?php
require_once __DIR__ . '/app/models/InspeccionLocativa.php';

echo "=== VERIFICACIÓN DE INSPECCIONES LOCATIVAS ===" . PHP_EOL;

$inspecciones = InspeccionLocativa::getFiltered('', '', '', '', '', '', '', '', 'id_asc');

echo "✅ Total de inspecciones encontradas: " . count($inspecciones) . PHP_EOL . PHP_EOL;

if (!empty($inspecciones)) {
    echo "=== PRIMERA INSPECCIÓN (para ver campos disponibles) ===" . PHP_EOL;
    $primera = $inspecciones[0];
    foreach ($primera as $campo => $valor) {
        echo "- $campo: " . ($valor ?? 'NULL') . PHP_EOL;
    }
    
    echo PHP_EOL . "=== TODAS LAS INSPECCIONES ===" . PHP_EOL;
    foreach ($inspecciones as $index => $inspeccion) {
        echo ($index + 1) . ". ID: " . $inspeccion['id_insp_loc'];
        echo " | Tipo: " . ($inspeccion['tipo_inspeccion'] ?? 'Sin tipo');
        echo " | Estado: " . ($inspeccion['estado_inspeccion'] ?? 'Sin estado');
        echo " | Categoría: " . ($inspeccion['categoria_nombre'] ?? 'Sin categoría');
        echo " | Empleado: " . ($inspeccion['empleado_nombre'] ?? 'Sin empleado');
        echo " | Área: " . ($inspeccion['area_nombre'] ?? 'Sin área');
        echo PHP_EOL;
    }
} else {
    echo "❌ No se encontraron inspecciones" . PHP_EOL;
}
?>