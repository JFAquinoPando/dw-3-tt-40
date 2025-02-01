<?php
    session_start();
    header("Content-Type: application/json");
    require "./../carga-productos/php/conexion.php";

    $campo1 = $_POST["campo1"];
    $campo2 = $_POST["campo2"];

    $sql = "SELECT campo3 FROM clientes WHERE campo1 like '%$campo1%' and campo2 like '%$campo2%'";
    //echo $sql;

    $res = $conexion->query($sql);

    $datos = $res->fetch_assoc();


    $_SESSION["usuario"] = $datos["campo3"];
    
    echo json_encode([
        "usuario" => $datos["campo3"]
    ]);