<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Carro</title>
</head>
<body>
    <h2>Cadastro de Carro</h2>
    
    <?php
    // Defina as credenciais do banco de dados
    include('connectionFactory.php');
    $conn = getConnection();
    // Processa o formulário quando enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $placa = $_POST['placa'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $cor = $_POST['cor'];

        // Prepara e executa a inserção no banco de dados
        $stmt = $conn->prepare("INSERT INTO carros (placa, marca, modelo, cor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $placa, $marca, $modelo, $cor);

        if ($stmt->execute()) {
            echo "<p>Carro cadastrado com sucesso!</p>";
        } else {
            echo "<p>Erro: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
    
    // Fecha a conexão
    $conn->close();
    ?>

    <form action="cadastro_carro.php" method="POST">
        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required><br><br>
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required><br><br>
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required><br><br>
        <label for="cor">Cor:</label>
        <input type="text" id="cor" name="cor" required><br><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
