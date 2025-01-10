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
$sql = "SELECT * FROM Administrador WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
?>
    <script>
        alert("Administrador não encontrado!");
        window.history.back();
    </script>
<?php
    exit;
}

$row = $result->fetch_assoc();

if ($row['instituicao'] !== $instiID) {
?>
    <script>
        alert("Você não tem permissão para editar esse registro!");
        window.history.back();
    </script>
<?php
    exit;
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

        <div class="container" id="form-container">
            <h1 id="h1-login">Edição de Administrador</h1>
            <br>
            <form action="" onclick="" method="POST">
                <div class="mb-3 mt-3">
                    <label for="nome" class="form-label">Nome do administrador</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['nome']?>">
                </div>

                <div class="mb-3 mt-3">

                </div>

                <div class="mb-3 mt-3">

                </div>

                <div class="mb-3 mt-3">

                </div>
            </form>
        </div>
    </nav>
</body>

</html>