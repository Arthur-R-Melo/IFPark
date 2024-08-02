var request;

function enviar() {
    try {
        let email = document.getElementById("email").value;
        let password = document.getElementById("senha").value;

        request = new XMLHttpRequest();
        //Dá pra fazer usando o evento load/método onload mas precisa tratar erro com onerror
        request.addEventListener("load", processaDadoServidor, false);
        request.onerror = function() {
            alert(`ERROR: ${request.status}`);
        }
        request.open('GET', `http://4.228.227.52:8080/atividadelogin/autenticar?email=${email}&senha=${password}`

            , true);
        request.send(null);

    } catch (exception) {
        alert('problema no envio de dados');
    }
}

function processaDadoServidor() {
    if (request.responseText === "true") {
        window.location.href = "index.html";
    } else {
        alert("Email ou senhas incorretos!");
    }
}
