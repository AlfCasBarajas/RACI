<?php
require_once __DIR__ . '/app/models/CondicionInsegura.php';

echo "=== PRUEBA CORREGIDA DEL MODELO CondicionInsegura ===" . PHP_EOL;

// Simular llamada corregida del controlador
$nombre = '';  // Sin filtro por nombre
$orden = 'nombre_asc';

echo "Llamada corregida: CondicionInsegura::getFiltered('', '$nombre', '$orden')" . PHP_EOL;
$condiciones = CondicionInsegura::getFiltered('', $nombre, $orden);

echo "✅ Registros encontrados: " . count($condiciones) . PHP_EOL . PHP_EOL;

foreach ($condiciones as $index => $condicion) {
    echo ($index + 1) . ". ID: " . $condicion['id_cond_inseg'];
    echo " | Nombre: " . $condicion['nombre']; 
    echo " | Lugar: " . $condicion['lugar'] . PHP_EOL;
}

echo PHP_EOL . "=== PRUEBA CON FILTRO POR NOMBRE ===" . PHP_EOL;

$nombreFiltro = 'piso';
echo "Filtrando por nombre que contenga '$nombreFiltro':" . PHP_EOL;
$condicionesFiltradas = CondicionInsegura::getFiltered('', $nombreFiltro, $orden);
echo "✅ Registros encontrados: " . count($condicionesFiltradas) . PHP_EOL;

foreach ($condicionesFiltradas as $condicion) {
    echo "- " . $condicion['nombre'] . " (" . $condicion['lugar'] . ")" . PHP_EOL;
}
?>