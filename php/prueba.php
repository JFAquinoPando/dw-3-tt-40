<?php

// Include the main TCPDF library (search for installation path).
require_once('./tcpdf/examples/tcpdf_include.php');
require_once "./../carga-productos/php/conexion.php";

$carrito_id = $_GET["id"];

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
// set default header data
/* $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING); */

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


$sql = "SELECT 
c.id as cliente_id, c.campo1 as nombre,
c.campo2 as apellido, c.campo3 as documento,
cd.producto_id, cd.precio_unitario, cd.cantidad, cd.total_pagar_producto,
p.campo1 as producto
FROM carrito_cabecera as cc
INNER JOIN carrito_detalle as cd 
ON cd.cabecera_id = cc.id
INNER JOIN clientes as c ON
c.id = cc.cliente
INNER JOIN productos as p
ON p.id = cd.producto_id
where
cc.finalizado = 1
and
cc.id = {$carrito_id}";

$res = $conexion->query($sql);

$factura = [
    "nombre" => "",
    "apellido" => "",
    "documento" => "",
    "productos" => []
];

while ($fila = $res->fetch_assoc()) {
    $factura['nombre'] = $fila["nombre"];
    $factura['apellido'] = $fila["apellido"];
    $factura['documento'] = $fila["documento"];
    array_push($factura['productos'], $fila);
}
$e = json_encode($factura);

$productosUsar = array_map(function($producto){
    return "
    <li>{$producto["producto_id"]} - {$producto["producto"]} | Total: {$producto["total_pagar_producto"]} </li>
    ";
}, $factura['productos']);

// create some HTML content
$mostar = implode("",$productosUsar);

$total = array_column($factura["productos"], 'total_pagar_producto');
$total = array_sum($total);

$html = <<<EEP
<h1>Factura a nombre de {$factura["nombre"]} {$factura["apellido"]} </h1>
<h2>Documento {$factura["documento"]}</h2>
<h2>Productos:</h2>
<ul>
{$mostar}
</ul>
<h3>Total a pagar: {$total}</h3>
EEP;

$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print all HTML colors

// add a page
//$pdf->AddPage();

$textcolors = '<h1>HTML Text Colors</h1>';
$bgcolors = '<hr /><h1>HTML Background Colors</h1>';

foreach(TCPDF_COLORS::$webcolor as $k => $v) {
    $textcolors .= '<span color="#'.$v.'">'.$v.'</span> ';
    $bgcolors .= '<span bgcolor="#'.$v.'" color="#333333">'.$v.'</span> ';
}
/* 
// output the HTML content
$pdf->writeHTML($textcolors, true, false, true, false, '');
$pdf->writeHTML($bgcolors, true, false, true, false, ''); */

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -




// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+