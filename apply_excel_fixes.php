<?php
// Script para corregir el reporte de Excel de inspecciones locativas

$file = __DIR__ . '/app/controllers/ReportesController.php';
$content = file_get_contents($file);

// Corrección 1: Cambiar el rango de encabezados solo en la función generateInspeccionesExcelReporte
$content = preg_replace(
    '/(\$headerRange = \'A\' \. \$headerRow \. \':M\' \. \$headerRow;)(?=.*generateInspeccionesExcelReporte.*}/s',
    '$headerRange = \'A\' . $headerRow . \':N\' . $headerRow;',
    $content,
    1
);

// Corrección 2: Agregar la nueva columna de datos
$oldDataPattern = '/(\$sheet->setCellValue\(\'K\' \. \$dataRow, \$inspeccion\[\'riesgo_tipo\'\] \?\? \'\'\);)\s*(\$sheet->setCellValue\(\'L\' \. \$dataRow, !empty\(\$inspeccion\[\'empleado_nombre\'\]\) \? \$inspeccion\[\'empleado_nombre\'\] : \'Sin empleado\'\);)\s*(\$sheet->setCellValue\(\'M\' \. \$dataRow, !empty\(\$inspeccion\[\'area_nombre\'\]\) \? \$inspeccion\[\'area_nombre\'\] : \'Sin área\'\);)/';

$newDataReplacement = '$1
            $sheet->setCellValue(\'L\' . $dataRow, !empty($inspeccion[\'condicion_insegura_nombre\']) ? $inspeccion[\'condicion_insegura_nombre\'] : \'Sin condición insegura\');
            $sheet->setCellValue(\'M\' . $dataRow, !empty($inspeccion[\'empleado_nombre\']) ? $inspeccion[\'empleado_nombre\'] : \'Sin empleado\');
            $sheet->setCellValue(\'N\' . $dataRow, !empty($inspeccion[\'area_nombre\']) ? $inspeccion[\'area_nombre\'] : \'Sin área\');';

$content = preg_replace($oldDataPattern, $newDataReplacement, $content);

// Corrección 3: Actualizar anchos de columnas
$oldWidthPattern = '/(\$sheet->getColumnDimension\(\'K\'\)->setWidth\(15\); \/\/ Riesgo\s*)(\$sheet->getColumnDimension\(\'L\'\)->setWidth\(20\); \/\/ Empleado\s*)(\$sheet->getColumnDimension\(\'M\'\)->setWidth\(15\); \/\/ Área)/';

$newWidthReplacement = '$1$sheet->getColumnDimension(\'L\')->setWidth(20); // Condición Insegura
        $sheet->getColumnDimension(\'M\')->setWidth(20); // Empleado
        $sheet->getColumnDimension(\'N\')->setWidth(15); // Área';

$content = preg_replace($oldWidthPattern, $newWidthReplacement, $content);

// Corrección 4: Cambiar rango de tabla
$content = str_replace(
    '$tableRange = \'A\' . $headerRow . \':M\' . ($dataRow - 1);',
    '$tableRange = \'A\' . $headerRow . \':N\' . ($dataRow - 1);',
    $content
);

// Corrección 5: Cambiar rango de colores alternados
$content = str_replace(
    '$sheet->getStyle(\'A\' . $row . \':M\' . $row)->getFill()',
    '$sheet->getStyle(\'A\' . $row . \':N\' . $row)->getFill()',
    $content
);

// Escribir el archivo corregido
file_put_contents($file, $content);

echo "Correcciones aplicadas exitosamente a ReportesController.php\n";
?>