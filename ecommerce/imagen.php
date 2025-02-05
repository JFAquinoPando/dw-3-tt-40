<?php
header("Content-Type: image/webp");
$archivo = $_GET["nombre"];
/* $i = imagecreatefromwebp(__DIR__."/../carga-productos/imagen-productos/{$archivo}");
imagewebp($i);
imagedestroy($i); */

$ruta_archivo = __DIR__."/../carga-productos/imagen-productos/{$archivo}";

// Verificar si el archivo existe y es legible
if (is_readable($ruta_archivo)) {
  // Leer el archivo y enviarlo directamente al navegador
  readfile($ruta_archivo);
} else {
  // Manejar el caso en que el archivo no existe o no se puede leer
  http_response_code(404);
  echo "Imagen no encontrada.";
}
