<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Detalles de Productos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module">

        fetch("/dw-3-tt-40/ecommerce/productos-carrito.php?consultar=productos&carritoId=" + carritoId)
            .then(
                p => p.json()
            ).then(
                resultado => {
                    const detalles = resultado.map(
                        (producto, idx) => {
                            return `<tr>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">${idx + 1}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">${producto.descripcion}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">${producto.cantidad}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">${producto.precio_unitario}</td>
                            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">${producto.total_pagar_producto}</td>
                        </tr>`
                        }
                    );
                    console.log("detalles", detalles);
                    $("tbody").insertAdjacentHTML("afterbegin", detalles.join(""))
                }
            )
    </script>
</head>

<body class="bg-indigo-500">
    <section class="container mx-auto px-4 bg-green-500">
        <h3 class="">Listado de productos</h3>
        <div>


        </div>
        <table class="table-auto bg-red-700">
            <thead>
                <tr>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Nro
                    </th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Producto/Descripcion
                    </th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Cantidad
                    </th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Precio Unitario
                    </th>
                    <th
                        class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Costo Total
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
            </tbody>
        </table>
        <div class="text-center py-2">
            <button
                class="btn-pagar px-4 py-2 font-semibold text-sm bg-gray-500 text-white rounded-full shadow-sm">COMPRAR</button>
        </div>
    </section>
    <script>
        const $ = (selector) => document.querySelector(selector)

        const carritoId = localStorage.getItem("carrito")
        $(".btn-pagar").addEventListener("click", () => {
            fetch("/dw-3-tt-40/ecommerce/productos-carrito.php?consultar=pagar&carritoId=" + carritoId).then(p => p.json())
                .then(respuestaCompra => {
                    Swal.fire({
                        title: "Resultado de compra",
                        text: respuestaCompra.mensaje,
                        icon: "success"
                    });
                })
                $("tbody").innerHTML = ""
        })
    </script>
</body>

</html>