<?php
include_once "connectionFactory.php";
session_start();

if (!isset($_SESSION['instituicao']) || $_SESSION['instituicao'] !== true || !isset($_SESSION['instituicao_ID'])) {
?>
    <script>
        alert("Você precisa estar logado como uma instituição para isso!");
        window.history.back();
    </script>
<?php
    die();
}

$instiID = $_SESSION['instituicao_ID'];
$conn = getConnection();
$id = intval($_GET['id']);
$sqlCheck = "SELECT * FROM Administrador WHERE id = ?";

$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param('i', $id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows <= 0) {
?>
    <script>
        alert("Administrador não encontrado!");
        window.history.back();
    </script>
<?php
    exit;
}

$row = $resultCheck->fetch_assoc();

if ($row['instituicao'] !== $instiID) {
?>
    <script>
        alert("Você não tem permissão para editar esse registro!");
        window.history.back();
    </script>
    <?php
    exit;
}

if (isset($_POST['nome'])) {
    $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');

    $sqlUpdate = "UPDATE Adminstrador SET user = ?, nome = ?, email = ? WHERE id = ?";

    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $user, $nome, $email, $id);

    if ($stmtUpdate->execute()) {
    ?>
        <script>
            alert("Registro atualizado com sucesso!");
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("Erro ao atualizar registro!");
        </script>
    <?php
    }

    $stmtUpdate->close();
    $stmtCheck->close();
    $conn->close();
    ?>
    <script>
        window.history.back();
    </script>
<?php
    die;
}


?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo_ifpark_icon.png" type="image/png">
    <title>Edita Carro</title>
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
            <li><a href="logedin.php">INÍCIO</a></li>
            <li><a href="contato.html">CONTATO</a></li>
        </ul>

    </nav>

    <div class="container" id="form-container">
        <h1 id="h1-login">Edição de Administrador</h1>
        <br>
        <form action="edita-adm.php?id<?php echo $id ?>" onsubmit="return validateForm()" method="POST">
            <div class="mb-3 mt-3">
                <label for="nome" class="form-label">Nome do administrador</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['nome'] ?>">
                <div id="error-nome" style="color: red; display: none;">Por favor, preencha este campo.</div>
            </div>

            <div class="mb-3 mt-3">
                <label for="user" class="form-label">Nome de usuário</label>
                <input type="text" class="form-control" id="user" name="user" value="<?php echo $row['user'] ?>">
                <div id="error-user" style="color: red; display: none;">Por favor, preencha este campo.</div>
            </div>

            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email do usuário</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
                <div id="error-email" style="color: red; display: none;">Por favor, insira um email válido.</div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>

<script>
    function validateForm() {
        let isValid = true;

        // Validação do campo Nome
        const nome = document.getElementById("nome").value.trim();
        const errorNome = document.getElementById("error-nome");
        if (nome === "") {
            errorNome.style.display = "block";
            isValid = false;
        } else {
            errorNome.style.display = "none";
        }

        // Validação do campo Usuário
        const user = document.getElementById("user").value.trim();
        const errorUser = document.getElementById("error-user");
        if (user === "") {
            errorUser.style.display = "block";
            isValid = false;
        } else {
            errorUser.style.display = "none";
        }

        // Validação do campo Email (não obrigatório, mas deve ser válido se preenchido)
        const email = document.getElementById("email").value.trim();
        const errorEmail = document.getElementById("error-email");
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email !== "" && !emailRegex.test(email)) {
            errorEmail.style.display = "block";
            isValid = false;
        } else {
            errorEmail.style.display = "none";
        }

        return isValid;
    }
</script>

</html>

<?php
$stmtCheck->close();
$conn->close();
?>