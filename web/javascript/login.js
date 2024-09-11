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
            request.open('GET', `http://4.228.227.52:8080/atividadelogin/autenticar?user=${user}&senha=${password}`

                , true);
            request.send(null);

    } catch (exception) {
        alert('problema no envio de dados');
    }
}

function validaEmail(email) {
    const regex = /^[^\s]+@[^\s]+\.[^\s]+$/;
    return regex.test(email);
}

function processaDadoServidor() {
    let response = JSON.parse(request.responseText)

    if (response.response === "true") {
        alert("Logou!!!");
        window.location.href = "index.html";
    } else {
        alert("Email ou senhas incorretos!");
    }
}
