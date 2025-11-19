<?php
// Configurar zona horaria de Colombia
date_default_timezone_set('America/Bogota');

echo "=== VERIFICACIÓN DE ZONA HORARIA ===" . PHP_EOL;
echo "Zona horaria configurada: " . date_default_timezone_get() . PHP_EOL;
echo "Fecha/Hora actual (Colombia): " . date('Y-m-d H:i:s') . PHP_EOL;
echo "Día de la semana: " . date('l, j F Y') . PHP_EOL;
echo "=== FORMATOS USADOS EN REPORTES ===" . PHP_EOL;
echo "Formato reportes (d/m/Y H:i): " . date('d/m/Y H:i') . PHP_EOL;
echo "Formato nombres archivos (Y-m-d_H-i-s): " . date('Y-m-d_H-i-s') . PHP_EOL;
echo "=== FIN VERIFICACIÓN ===" . PHP_EOL;