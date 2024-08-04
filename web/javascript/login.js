var request;

function enviar() {
    try {
        let email = document.getElementById("email").value;
        let password = document.getElementById("senha").value;
        if (validaEmail(email)) {
            request = new XMLHttpRequest();
            /*Alterei o evento pois com o readystatechange seria necessário verificar se o estado da requisição está como finalizado.
            Utilizando os eventos load e error creio que o código fica,além de tudo, mais legível*/
            request.addEventListener("load", processaDadoServidor, false);
            request.onerror = function () {
                alert(`ERROR: ${request.status}`);
            }
            request.open('GET', `http://4.228.227.52:8080/atividadelogin/autenticar?email=${email}&senha=${password}`

                , true);
            request.send(null);
        } else {
            alert("Email inválido");
            return;
        }

    } catch (exception) {
        alert('problema no envio de dados');
    }
}

function validaEmail(email) {
    const regex = /^[^\s]+@[^\s]+\.[^\s]+$/;
    return regex.test(email);
}

function processaDadoServidor() {
    if (request.responseText === "true") {
        window.location.href = "index.html";
    } else {
        alert("Email ou senhas incorretos!");
    }
}
