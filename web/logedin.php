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
    <title>IFPark - Consulta Carros</title>
    <link rel="icon" href="images/logo_ifpark_icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css\style.css">    
</head>
<body>
    <header>
        <img src="images/ifpark_logoBranco_TXT.png" alt="IfPark Logo">
    </header>

    <nav>
        <ul>
            <li><a href="contato.html">CONTATO</a></li>
            <li><a href="cadastroCarro.html">CADASTRAR NOVO CARRO</a></li>
            <li><a href="control/logout.php">SAIR</a></li>
        </ul>
    </nav>

    <!-- Container dos Cardboxes -->
    
        <main>
            <div class="container-cards">
                <div class="cardbox">
                    <img src="images/empresaicon.png" alt="Informações da Empresa">
                    <h2>Informações da Empresa</h2>
                    <p>Gerencie as informações da sua empresa e escolha seu plano de serviço.</p>
                    <a href="dados-da-empresa.php" class="btn">Saiba Mais</a>
                </div>
                <div class="cardbox">
                    <img src="images/carroicon.png" alt="Controle de Veículos">
                    <h2>Controle de Veículos</h2>
                    <p>Gerencie e monitore os veículos de forma eficiente e integrada.</p>
                    <a href="consultaCarro.php" class="btn">Acessar</a>
                </div>
                <div class="cardbox">
                    <img src="images/pessoaicon.png" alt="Administradores">
                    <h2>Administradores</h2>
                    <p>Gerencie os administradores de forma simples e rápida.</p>
                    <a href="consulta-adm.php" class="btn">Ver Mais</a>
                </div>
            </div>
        </main>
        
    
</body>
</html>
