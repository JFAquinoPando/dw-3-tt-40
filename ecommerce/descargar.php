<?php
// descargar.php
$img = "https://woocommercecore.mystagingwebsite.com/wp-content/uploads/2017/12/vneck-tee-2.jpg";
$nombre =basename($img);
$descarga = file_get_contents($img);

file_put_contents(__DIR__."/../carga-productos/imagen-productos/{$nombre}", $descarga);
echo "ARCHIVO DESCARGADO";

function descargarImg($url){
    $nombre =basename($url);
    $descarga = file_get_contents($url);
    file_put_contents(__DIR__."/{$nombre}", $descarga);
    return $nombre;
    
}

