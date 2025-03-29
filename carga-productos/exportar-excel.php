<?php
include "./php/conexion.php";
require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue('A1', 'ID');
$activeWorksheet->setCellValue('B1', 'Producto');
$activeWorksheet->setCellValue('C1', 'Precio');

$sql = "SELECT * FROM productos";
$res = $conexion->query($sql);
$inicio=2;
while ($fila = $res->fetch_assoc()) {
    $activeWorksheet->setCellValue('A'.$inicio, $fila["id"]);
    $activeWorksheet->setCellValue('B'.$inicio, $fila["campo1"]);
    $activeWorksheet->setCellValue('C'.$inicio, $fila["campo2"]);
    $inicio++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('productos_en_web.xlsx');

// Establece las cabeceras para la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="productos_en_web.xlsx"');
header('Cache-Control: max-age=0');

// Lee el contenido del archivo .xlsx y envíalo al navegador
readfile(__DIR__."/productos_en_web.xlsx");

exit;