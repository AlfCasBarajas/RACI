<?php
require_once __DIR__ . '/app/models/Riesgo.php';

echo "=== VERIFICACIÓN DE RIESGOS ===" . PHP_EOL;

$riesgos = Riesgo::getFiltered('', '');

echo "✅ Total de riesgos encontrados: " . count($riesgos) . PHP_EOL . PHP_EOL;

foreach ($riesgos as $index => $riesgo) {
    echo ($index + 1) . ". ID: " . $riesgo['id_riesgo'];
    echo " | Tipo: " . $riesgo['tipo'];
    echo " | Descripción: " . $riesgo['descripcion'];
    echo " | Condición: " . ($riesgo['condicion_nombre'] ?? 'Sin condición');
    echo PHP_EOL;
}

echo PHP_EOL . "=== Verificando JOIN con condiciones inseguras ===" . PHP_EOL;

// Verificar que el JOIN funciona correctamente
$riesgoConCondicion = null;
foreach ($riesgos as $riesgo) {
    if (!empty($riesgo['condicion_nombre'])) {
        $riesgoConCondicion = $riesgo;
        break;
    }
}

if ($riesgoConCondicion) {
    echo "✅ JOIN funcionando correctamente:" . PHP_EOL;
    echo "   Riesgo: " . $riesgoConCondicion['tipo'] . PHP_EOL;
    echo "   Condición asociada: " . $riesgoConCondicion['condicion_nombre'] . PHP_EOL;
} else {
    echo "⚠️  No se encontraron riesgos con condiciones asociadas" . PHP_EOL;
}
?>