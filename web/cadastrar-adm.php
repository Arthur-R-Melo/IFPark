<?php
include('connectionFactory.php');
session_start();


if (!isset($_SESSION['instituicao']) || $_SESSION['instituicao'] !== true || !isset($_SESSION['instituicao_ID'])) {
?>
    <script>
        alert("Você precisa estar logado como uma instituição para isso!");
        window.history.back();
    </script>
    <?php
    die;
}


function isUserInDataBase($user, $idInst)
{
    try {
        $conn = getConnection();
        $sql = "SELECT * FROM Administrador WHERE user = ? AND instituicao = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Erro ao preparar statement: " . $conn->error);
        }

        $stmt->bind_param('si', $user, $idInst);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        return $result->num_rows > 0;
    } catch (Exception $e) {
    ?>
        <script>
            alert("Ocorreu uma exceção: <?php echo addslashes($e->getMessage()); ?>");
            console.log("<?php echo addslashes($e->getMessage()); ?>");
        </script>
    <?php
        return true;
    }
}

if (isset($_POST['nome'])) {


    if (!(isset($_POST['user']) && isset($_POST['senha']))) {
    ?>
        <script>
            alert("Alguma informação não foi definida!");
            window.history.back();
        </script>
    <?php
        die;
    }

    $user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
    $idInst = intval($_SESSION['instituicao_ID']);             // Converte para inteiro


    if (isUserInDataBase($user, $idInst)) {
    ?>
        <script>
            alert("Usuário já cadastrado");
            window.history.back();
        </script>
        <?php
        die();
    }

    try {
        $conn = getConnection();

        $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');;
        $senha = $_POST['senha'];

        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Administrador (instituicao, user, senha, nome, nivelDeAcesso) VALUES (?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Erro ao preparar statement: " . $conn->error);
        }

        $stmt->bind_param("isss", $idInst, $user, $hashedPassword, $nome);

        if ($stmt->execute()) {
        ?>
            <script>
                alert("Cadastro realizado com sucesso!");
                window.location.href = "logedin.php";
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("O cadastro falhou!");
                window.history.back();
            </script>
        <?php
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        ?>
        <script>
            alert("Ocorreu uma exceção: <?php echo addslashes($e->getMessage()); ?>");
            console.log("<?php echo addslashes($e->getMessage()); ?>");
        </script>
<?php
    }
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
                <label for="senha" class="form-label">Senha da conta</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Insira a senha do administrador">
                <div class="invalid-feedback" id="erroSenha">
                    A senha deve ser informada!
                </div>
            </div>
            <div class="mb-3">
                <label for="confirmaSenha" class="form-label">Confirme a senha</label>
                <input type="password" name="confirmaSenha" id="confirmaSenha" class="form-control" placeholder="Confirme a senha do administrador">
                <div class="invalid-feedback" id="erroConfirmaSenha">
                    As senhas devem coincidir!
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
        let temErro = false

        //Limpar erros anteriores
        const campos = ['nome', 'user', 'senha', 'confirmaSenha'];
        campos.forEach(campo => {
            const input = document.getElementById(campo);
            const erroDiv = document.getElementById('erro' + campo.charAt(0).toUpperCase() + campo.slice(1));

            input.classList.remove('is-invalid');
            erroDiv.style.display = 'none';
        });

        const nome = document.getElementById('nome').value;
        if (!nome) {
            document.getElementById('erroNome').style.display = 'block';
            document.getElementById('nome').classList.add('is-invalid');
            temErro = true;
        }

        const user = document.getElementById('user').value;
        if (!user) {
            document.getElementById('erroUser').style.display = 'block';
            document.getElementById('user').classList.add('is-invalid');
            temErro = true;
        }

        const senha = document.getElementById('senha').value;
        if (!senha) {
            document.getElementById('erroSenha').style.display = 'block';
            document.getElementById('senha').classList.add('is-invalid');
            temErro = true;
        }

        const confirmaSenha = document.getElementById('confirmaSenha').value;
        if (senha !== confirmaSenha) {
            document.getElementById('erroConfirmaSenha').style.display = 'block';
            document.getElementById('confirmaSenha').classList.add('is-invalid');
            temErro = true;
        }

        if (temErro) {
            event.preventDefault();
            return false;
        }

        return true;
    }
</script>

</html>