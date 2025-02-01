<?php
    header("Content-Type: application/json");
    require "./../carga-productos/php/conexion.php";
    $sql = "SELECT id, campo1, campo2, campo3 from productos";
    $res = $conexion->query($sql);
    $datos = [];
    while ($fila = $res->fetch_assoc()) {
        array_push($datos,[
            "imagen" => "imagen/{$fila["campo3"]}",
            "nombre" => $fila["campo1"],
            "precio" => $fila["campo2"]
        ]);
    }
    echo json_encode($datos);