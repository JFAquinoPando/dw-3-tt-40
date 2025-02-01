<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticar</title>
</head>
<body>
    <h1>Autenticar</h1>
    <form action="../php/verificar.php" method="post">
        <div><label for="campo1" name="campo1">campo1</label><input name="campo1"  type="text" id="campo1"></div>
        <div><label for="campo2" >campo2</label><input type="text" id="campo2" name="campo2"> </div>
        <div>
            <button>Iniciar</button>
        </div>
    </form>
    <script type="module">
        const $ = (s) => document.querySelector(s)
        const formulario = $("form")
       formulario.addEventListener("submit", (e) => {
        e.preventDefault()
        fetch(formulario.action, {
            method:formulario.method,
            body: new FormData(formulario)
        }).then(r => r.json())
        .then(resultado => {
            console.log(resultado,window.location.href);
            window.location.href = "http://localhost/dw-3-tt-40/carga-productos/"
            /* window.location.href = "http://localhost/dw-3-tt-40/carga-productos/index.php" */
        })
       })
    </script>
</body>
</html>