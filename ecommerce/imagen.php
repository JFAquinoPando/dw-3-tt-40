<?php
header("Content-Type: image/webp");
$archivo = $_GET["nombre"];
$i = imagecreatefromwebp(__DIR__."/../carga-productos/imagen-productos/{$archivo}");
imagewebp($i);
imagedestroy($i);

