<?php
    session_start();
    if(!isset($_SESSION["usuario"])){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <script defer src="./js/script.js"></script>
</head>
<body>
    <section>
        <h2>Cargar productos</h2>
        <div>
            <form action="./php/cargar.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="campo1">Producto</label><input type="text" id="campo1" placeholder="Ej: Caja" name="campo1"  required>
                </div>
                <div>
                    <label for="campo2">Precio</label><input type="text" id="campo2" placeholder="Ej: Gs. 200.000" name="campo2"  required>
                </div>
                <div>
                    <label for="campo3">Imagen</label><input type="file" id="campo3" accept=".jpg, .jpeg, .png, .webp" name="campo3"  required>
                </div>
                <button>Cargar</button>
            </form>
        </div>
    </section>
</body>
</html>