<?php
// Este archivo contiene las correcciones necesarias para la función generateInspeccionesExcelReporte
// Hay que reemplazar las siguientes líneas en el archivo ReportesController.php:

/*
Línea alrededor de 2654 - cambiar el rango de encabezados:
$headerRange = 'A' . $headerRow . ':N' . $headerRow;

Líneas alrededor de 2677-2680 - agregar la nueva columna de datos:
            $sheet->setCellValue('K' . $dataRow, $inspeccion['riesgo_tipo'] ?? '');
            $sheet->setCellValue('L' . $dataRow, !empty($inspeccion['condicion_insegura_nombre']) ? $inspeccion['condicion_insegura_nombre'] : 'Sin condición insegura');
            $sheet->setCellValue('M' . $dataRow, !empty($inspeccion['empleado_nombre']) ? $inspeccion['empleado_nombre'] : 'Sin empleado');
            $sheet->setCellValue('N' . $dataRow, !empty($inspeccion['area_nombre']) ? $inspeccion['area_nombre'] : 'Sin área');

Línea alrededor de 2695 - agregar ancho de columna para Condición Insegura:
        $sheet->getColumnDimension('L')->setWidth(20); // Condición Insegura
        $sheet->getColumnDimension('M')->setWidth(20); // Empleado
        $sheet->getColumnDimension('N')->setWidth(15); // Área

Línea alrededor de 2700 - cambiar el rango de tabla de M a N:
        $tableRange = 'A' . $headerRow . ':N' . ($dataRow - 1);

Línea alrededor de 2705 - cambiar el rango de colores alternados de M a N:
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()
*/
?>