<?php
    header("Content-Type: application/json");

    include "./../carga-productos/php/conexion.php";
    //consultar=productos
    if ($_REQUEST["consultar"] === "productos") {
        $carritoId = $_GET["carritoId"];
        $sql = "SELECT p.campo1 as descripcion, cd.cantidad, cd.precio_unitario, cd.total_pagar_producto
                FROM carrito_detalle as cd 
                INNER JOIN productos as p 
                ON cd.producto_id = p.id
                WHERE cd.cabecera_id = $carritoId";
        $res = $conexion->query($sql);

        $productosEnCarrito = [];

        while ($fila = $res->fetch_assoc()) {
            $productosEnCarrito[] = $fila;
        }

        echo json_encode($productosEnCarrito);
    }

    elseif ($_REQUEST["consultar"] === "pagar") {
        $carritoId = $_REQUEST["carritoId"];
        $sql = "UPDATE carrito_cabecera set finalizado = 1 where id = $carritoId";
        $res = $conexion->query($sql);
        if ($conexion->affected_rows) {
            echo json_encode([
                "mensaje" => "compra exitosa"
            ]);
        }else{
            echo json_encode([
                "mensaje" => "no hay productos para compra"
            ]);
        }
    }