<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
    header("Location: login.html");
    exit();
}

include('connectionFactory.php');
$sql = "SELECT * FROM Carro WHERE instituicao = " . $_SESSION['instituicao_ID'];
$conn = getConnection();
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Carros</title>
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
            <li><a href="cadastroCarro.html">CADASTRAR NOVO CARRO</a></li>
        </ul>
    </nav>
</body>

</html>