<?php
    session_start();
    /* if(!isset($_SESSION["usuario"])){
        header("Location: login.php");
    } */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Carga de productos por archivo CSV</h3>
    <form action="cargar-productos.php" method="post" enctype="multipart/form-data">
        <label for="archivo">Coloca tu archivo, CSV</label>
        <input type="file" name="archivo" id="archivo" accept="text/*">
        <button>Cargar</button>
    </form>

    <hr>

    <section>
        <a href="./exportar-excel.php" target="_blank">Mostrar/Exportar productos en Excel</a>
    </section>
</body>
</html>