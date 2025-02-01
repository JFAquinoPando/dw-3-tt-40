<?php
    header("Content-Type: application/json");

    require "./conexion.php";

    function verificarDato($peticion, $campo){
        return isset($peticion) ? $peticion : exit(json_encode([
            "mensaje" => "falta cargar campo '{$campo}'",
            "id" => 0
        ]));
    }

    function verificarImagen(){
        if (!isset($_FILES["campo3"])) {
            exit(json_encode([
                "mensaje" => "falta cargar campo 'imagen'",
                "id" => 0
            ]));
        }
        $peticionImagen = $_FILES["campo3"];
        //$_FILES --- $peticionImagen
        if($peticionImagen["type"] === "image/webp"){
            move_uploaded_file($peticionImagen["tmp_name"], 
            "./../imagen-productos/{$peticionImagen["name"]}");
            $nombreImagen = $peticionImagen["name"];
        }else{
           if($peticionImagen["type"] === "image/jpeg" || $peticionImagen["type"] === "image/jpg"){
                $imagen = imagecreatefromjpeg($peticionImagen["tmp_name"]);
                $nombre = basename(strtolower($peticionImagen["name"]), ".jpg");
                $nombre = basename(strtolower($nombre), ".jpeg");
                $nombre .= ".webp";
                imagewebp($imagen, __DIR__."/../imagen-productos/{$nombre}",90); 
                imagedestroy($imagen); 
                $nombreImagen = $nombre;
           }
        }
        return $nombreImagen;


    }

/* ampo3
: 
{name: "Imagen4.png", full_path: "Imagen4.png", type: "image/png",tmp_name} */


    $producto =  verificarDato($_POST["campo1"], "producto");
    $precio   =  verificarDato($_POST["campo2"], "precio");
    $imagen = verificarImagen();

    $sql = "INSERT INTO productos (campo1, campo2, campo3) 
    VALUES
    ('{$producto}', '{$precio}', '{$imagen}')";

    $conexion->query($sql);
    $id = $conexion->insert_id;

    echo json_encode([
        "mensaje" => "producto guardado",
        "id" => $id
    ]);