<?php
    header("Content-Type: application/json");
    include "./../carga-productos/php/conexion.php";

    $productosPrecios = [];
    $sql = "SELECT id, campo2 from productos";
    $r = $conexion->query($sql);
    while ($fila = $r->fetch_assoc()) {
        $productosPrecios[$fila["id"]] = $fila["campo2"];
    } 

    /* 
    $productosPrecios ------|
                            |
    array(                 <-
        1 => 25000
        2 => 47000
    )
    */

    $cliente = 1;
    $carrito_id = null;
    $producto = $_POST["producto_id"];    
    $sql1 = "CREATE TABLE  IF NOT EXISTS carrito_cabecera(
        id int auto_increment primary key,
        cliente int,
        total int,
        finalizado int
    )";
    
    $conexion->query($sql1);

    $sql1 = "CREATE TABLE IF NOT EXISTS carrito_detalle(
        id int auto_increment primary key,
        cabecera_id int,
        posicion_producto int,
        producto_id int,
        precio_unitario int,
        cantidad int,
        total_pagar_producto int,
        FOREIGN KEY (cabecera_id) REFERENCES carrito_cabecera(id)
    )";
    
    $conexion->query($sql1);

    $sql = "SELECT id from carrito_cabecera where cliente = '{$cliente}' and finalizado = 0";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows) {
        $fila = $resultado->fetch_assoc();
        $carrito_id = $fila["id"];
    }else{
        $sql = "INSERT INTO carrito_cabecera (cliente, total,finalizado) values ('{$cliente}',0,0)";
        $resultado = $conexion->query($sql);
        $carrito_id = $conexion->insert_id;
    }

    $sql = "INSERT INTO carrito_detalle (cabecera_id, posicion_producto, producto_id, 
    precio_unitario, cantidad, total_pagar_producto) values 
    ($carrito_id, 0, $producto, {$productosPrecios[$producto]}, 1, 1*{$productosPrecios[$producto]})";

    $conexion->query($sql);

    echo json_encode(["carrito" => $carrito_id]);



