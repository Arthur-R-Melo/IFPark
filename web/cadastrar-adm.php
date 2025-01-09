<?php
if (!(isset($_SESSION['instituicao']) && $_SESSION['instituicao'] === true)) {
?>
    <script>
        alert("Você precisa estar logado como uma instituição para isso!");
        window.history.back();
    </script>
<?php
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFPark - Cadastro de Administrador</title>
    <link rel="icon" href="images/logo_ifpark_icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <img src="images/ifpark_logoBranco_TXT.png" alt="IfPark Logo">
    </header>

    <nav>
        <ul>
            <li><a href="index.html">INÍCIO</a></li>
            <li><a href="contato.html">CONTATO</a></li>
        </ul>
    </nav>

    <div class="container" id="form-container">
        <h1 id="h1-login">Cadastro de Administrador</h1>
        <br>
        <form action="cadastrar-adm.php" onsubmit="return validarFormulario(event)" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da conta</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Insira o nome do administrador">
                <div class="invalid-feedback" id="erroNome">
                    O nome da conta deve estar preenchido!
                </div>
            </div>
            <div class="mb-3">
                <label for="user" class="form-label">Nome de Usuário</label>
                <input type="text" name="user" id="user" class="form-control" placeholder="Insira o nome de usuário">
                <div class="invalid-feedback" id="erroUser">
                    O nome de usuário deve estar preenchido!
                </div>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Nome da conta</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Insira a senha do administrador">
                <div class="invalid-feedback" id="erroSenha">
                    O nome da conta deve estar preenchido!
                </div>
            </div>
        </form>
    </div>
</body>
<script>
    function validarFormulario(event) {
        let temErro = false

        //Limpar erros anteriores
        const campos = ['nome', 'user', 'senha'];
        campos.forEach(campo => {
            const input = document.getElementById(campo);
            const erroDiv = document.getElementById('erro' + campo.charAt(0).toUpperCase() + campo.slice(1));

            input.classList.remove('is-invalid');
            erroDiv.style.display = 'none';
        });
    }
</script>

</html>