var request;

function enviar() {
    try {
        let user = document.getElementById("email").value;
        let password = document.getElementById("senha").value;
            request = new XMLHttpRequest();
            /*Alterei o evento pois com o readystatechange seria necessário verificar se o estado da requisição está como finalizado.
            Utilizando os eventos load e error creio que o código fica,além de tudo, mais legível*/
            request.addEventListener("load", processaDadoServidor, false);
            request.onerror = function () {
                alert(`ERROR: ${request.status}`);
            }
            request.open('GET', `/login.php?user=${user}&senha=${password}`

                , true);
            request.send(null);
            console.log('enviou!!!')

    } catch (exception) {
        alert('problema no envio de dados');
    }
}


function processaDadoServidor() {
    console.log("Aqui")
    let response = JSON.parse(request.responseText)

    if (response.response === "true") {
        alert("Logou!!!");
        window.location.href = "index.html";
    } else {
        alert("Usuário ou senhas incorretos!");
    }
}
