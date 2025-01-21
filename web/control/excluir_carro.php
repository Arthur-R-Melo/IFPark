<?php
include_once "connectionFactory.php";
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['instituicao_ID'])) {
?>
    <script>
        alert("Você precisa estar logado para isso!");
        window.history.back();
    </script>
<?php
    die;
}

if (isset($_GET['idCarro'])) {
    $id = $_GET['idCarro'];
    $conn = getConnection();

    $sqlCheck = "SELECT id FROM Carro WHERE id = ? AND instituicao = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $id, $_SESSION['instituicao_ID']);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows <= 0) {
        ?>
        <script>
            alert("Você não tem permissão para excluir esse carro")
            window.history.back();
        </script>
        <?php
    }

    $sql = "DELETE FROM Carro WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            alert("Veículo excluído com sucesso")
            window.history.back();
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("erro ao excluir veículo!")
            window.history.back();
        </script>
        <?php
    }
}else{
    ?>
    
    <script>
    alert("ID do carro não informado!")
    window.history.back()</script>
    <?php
}
?>