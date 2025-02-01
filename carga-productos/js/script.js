const $ = (elemento) => document.querySelector(elemento)

const formulario = $("form")
formulario.addEventListener("submit", (evento) =>{
    evento.preventDefault()
    fetch(formulario.action, {
        method: formulario.method,
        body: new FormData(formulario)
    })
})