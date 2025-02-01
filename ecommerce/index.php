<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        section{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2em;
           article{
            img{
                width: 100%;
                aspect-ratio: 16/9;
                object-fit: cover;
            }
           }
        }
    </style>
</head>
<body>
    <h2>Tienda</h2>
    <section id="php">
        <?php
            require "./../carga-productos/php/conexion.php";
            $sql = "SELECT id, campo1, campo2, campo3 from productos";
            $res = $conexion->query($sql);
            while ($fila = $res->fetch_assoc()) {
                echo "<article>
                        <div>
                            <img src='imagen/{$fila["campo3"]}'>
                        </div>
                        <h3>{$fila["campo1"]}</h3>
                        <h4>{$fila["campo2"]}</h4>
                </article>";
            }



        ?>
    </section>
    <section id="js"></section>
    <script type="module">
fetch("http://localhost/dw-3-tt-40/ecommerce/datos.php").then(
    p => p.json()
).then(
    articulos => {
        const articulosJs =document.querySelector("#js")
        articulos.map(art => {
            articulosJs.insertAdjacentHTML("afterbegin", `
            <article>
                        <div>
                            <img src='${art.imagen}'>
                        </div>
                        <h3>${art.nombre}</h3>
                        <h4>${art.precio}</h4>
                </article>
            
            `)
        })
    }
)

    </script>
</body>
</html>