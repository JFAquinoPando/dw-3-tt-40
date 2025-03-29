<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos compras</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2em;

            article {
                img {
                    width: 100%;
                    aspect-ratio: 16/9;
                    object-fit: cover;
                }
            }
        }

        .carrito-posicion {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="carrito-posicion">
        <a href="./carrito-compra.php" style="display: flex;gap: 0.4em;">
            <span class="cantidad"></span>
            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 902.86 902.86"
                xml:space="preserve">
                <g>
                    <g>
                        <path d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z
             M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z" />
                        <path d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717
            c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744
            c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742
            C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744
            c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z
             M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742
            S619.162,694.432,619.162,716.897z" />
                    </g>
                </g>
            </svg>
        </a>
    </div>
    <h2>Tienda</h2>
    <section id="php">
        <?php
        require "./../carga-productos/php/conexion.php";
        $sql = "SELECT id, campo1, campo2, campo3 from productos";
        $res = $conexion->query($sql);
        while ($fila = $res->fetch_assoc()) {

            $imagen = str_contains( $fila["campo3"], "https://" ) 
            ?  $fila["campo3"]
            : "imagen/{$fila["campo3"]}";

            echo "<article>
                        <div>
                            <img src='{$imagen}' width='607.22' height='342'>
                        </div>
                        <h3>{$fila["campo1"]}</h3>
                        <h4>{$fila["campo2"]}</h4>
                        <button class='btn-comprar px-4 py-2 font-semibold text-sm bg-cyan-500 text-white rounded-full shadow-sm' data-producto='{$fila["id"]}'>Comprar</button>
                </article>";
        }



        ?>
    </section>
    <section id="js"></section>
    <script type="module">

        const $ = (selector) => document.querySelector(selector)

        fetch("http://localhost/dw-3-tt-40/ecommerce/datos.php").then(
            p => p.json()
        ).then(
            articulos => {
                const articulosJs = document.querySelector("#js")
                articulos.map(art => {
                    articulosJs.insertAdjacentHTML("afterbegin", `
                    <article>
                                <div>
                                    <img src='${art.imagen}' width="608" height="342">
                                </div>
                                <h3>${art.nombre}</h3>
                                <h4>${art.precio}</h4>
                                <button class='btn-comprar px-4 py-2 font-semibold text-sm bg-cyan-500 text-white rounded-full shadow-sm' data-producto='${art.id}'>Comprar</button>
                        </article>
                    
                    `)
                })
            }
        )


        /* Obtener cantidad de elementos a comprar */
        const carritoId = localStorage.getItem("carrito")
        fetch("/dw-3-tt-40/ecommerce/productos-carrito.php?carritoId="+carritoId)
        .then(
            p => p.json()
        ).then(
            resultado => {
                const cantidad = resultado.length
                $(".cantidad").textContent = cantidad
            }
        )

        /* Activo la delegación de eventos */

        const cuerpo = $("body")
        cuerpo.addEventListener("click", (e) => {
            console.log("Hiciste click en ", e);
            const elemento = e.target
            if (elemento.tagName === "BUTTON" && elemento.classList.contains("btn-comprar")) {
                const idProducto = elemento.dataset.producto
                console.log({ idProducto });
                const pedir = new FormData();
                pedir.append("producto_id", idProducto)

                fetch("carrito.php", {
                    method: "POST",
                    body: pedir
                }).then(r => r.json()).
                    then(resultado => {
                        localStorage.setItem("carrito", resultado.carrito)
                        Swal.fire({
                            title: "Carrito de Todo Compras",
                            text: "Su producto ha sido cargado",
                            icon: "success"
                        });
                        console.log({ resultado });
                    })
            }
        })
    </script>
</body>

</html>