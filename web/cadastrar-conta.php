<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFPark - Cadastro de Conta</title>
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
            <li><a href="login.html">LOGIN</a></li>
        </ul>
    </nav>

    <div class="container" id="form-container">
        <h1 id="h1-login">Cadastro de Instituição</h1>
        <br>
        <form action="control/cadastroControl.php" onsubmit="return validarFormulario(event)" method="POST">
            <div class="mb-3">
                <label for="nomeInst" class="form-label">Nome da Instituição</label>
                <input type="text" class="form-control" name="nomeInst" id="nomeInst" placeholder="Insira o nome da instituição">
                <div class="invalid-feedback" id="erroNomeInst">
                    O nome da instituição é obrigatório.
                </div>
            </div>

            <div class="mb-3">
                <label for="emailInst" class="form-label">Email da instituição</label>
                <input type="email" name="emailInst" id="emailInst" class="form-control" placeholder="Insira o email da instituição">
                <div class="invalid-feedback" id="erroEmailInst">
                    O e-mail da instituição é inválido.
                </div>
            </div>

            <div class="mb-3">
                <label for="document" class="form-label">CPF/CNPJ</label>
                <input type="text" name="document" id="document" class="form-control" placeholder="Insira o documento (CPF/CNPJ)">
                <div class="invalid-feedback" id="erroDocument">
                    O CPF ou CNPJ é inválido.
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Insira a senha</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Insira a senha">
                <div class="invalid-feedback" id="erroPassword">
                    A senha é obrigatória.
                </div>
            </div>

            <div class="mb-3">
                <label for="passwordConfirm" class="form-label">Confirme a senha</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Confirme sua senha">
                <div class="invalid-feedback" id="erroPasswordConfirm">
                    As senhas não coincidem.
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" value="Cadastrar" class="btn btn-success">
                <input type="reset" value="Limpar" class="btn btn-warning">
            </div>
        </form>
    </div>
</body>

<script>
    function validarFormulario(event) {
        let temErro = false;

        // Limpar qualquer erro anterior
        const campos = ['nomeInst', 'emailInst', 'document', 'password', 'passwordConfirm'];
        campos.forEach(campo => {
            const input = document.getElementById(campo);
            const erroDiv = document.getElementById('erro' + campo.charAt(0).toUpperCase() + campo.slice(1));

            input.classList.remove('is-invalid');
            erroDiv.style.display = 'none';
        });

        // Validação para o nome da instituição
        const nomeInst = document.getElementById('nomeInst').value;
        if (!nomeInst) {
            document.getElementById('erroNomeInst').style.display = 'block';
            document.getElementById('nomeInst').classList.add('is-invalid');
            temErro = true;
        }

        // Validação para o email da instituição
        const emailInst = document.getElementById('emailInst').value;
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(emailInst)) {
            document.getElementById('erroEmailInst').style.display = 'block';
            document.getElementById('emailInst').classList.add('is-invalid');
            temErro = true;
        }

        // Validação para CPF/CNPJ
        const documentValue = document.getElementById('document').value;
        const documentRegex = /^[0-9]{11}$|^[0-9]{14}$/; // Simplificado para CPF ou CNPJ (apenas números)
        if (!documentRegex.test(documentValue)) {
            document.getElementById('erroDocument').style.display = 'block';
            document.getElementById('document').classList.add('is-invalid');
            temErro = true;
        }

        // Validação para a senha
        const password = document.getElementById('password').value;
        if (!password) {
            document.getElementById('erroPassword').style.display = 'block';
            document.getElementById('password').classList.add('is-invalid');
            temErro = true;
        }

        // Validação para confirmação da senha
        const passwordConfirm = document.getElementById('passwordConfirm').value;
        if (password !== passwordConfirm) {
            document.getElementById('erroPasswordConfirm').style.display = 'block';
            document.getElementById('passwordConfirm').classList.add('is-invalid');
            temErro = true;
        }

        // Se houver erro, impede o envio do formulário
        if (temErro) {
            event.preventDefault();
            return false;
        }

        return true; // Se todos os campos forem válidos, permite o envio
    }
</script>

</html>