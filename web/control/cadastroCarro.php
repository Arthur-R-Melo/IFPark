<?php

try {
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: login.html");
        exit();
    }

    // Defina as credenciais do banco de dados
    include('../connectionFactory.php');
    $conn = getConnection();
    // Processa o formulário quando enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $placa = $_POST['placa'];
        $proprietario = $_POST['proprietario'];
        $instituicao = $_SESSION['instituicao_ID'];

        // Prepara e executa a inserção no banco de dados
        $stmt = $conn->prepare("INSERT INTO Carro (instituicao, placa, proprietario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $instituicao, $placa, $proprietario);

        if ($stmt->execute()) {
?>
            <script>
                alert("Cadastro realizado com sucesso!");
                window.location.href = "../consultaCarro.php";
            </script>
<?php
        } else {
            echo "<p>Erro: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    // Fecha a conexão
    $conn->close();
} catch (Exception $cavalo) {
    echo $cavalo;
}
