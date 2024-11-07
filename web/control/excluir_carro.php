<?php
include_once "../connectionFactory.php";

if (isset($_GET['idCarro'])) {
    $id = $_GET['idCarro'];
    $conn = getConnection();

    $sql = "DELETE FROM Carro WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            alert("Veículo excluído com sucesso")
            window.location = "../logedin.php";
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("erro ao excluir veículo!")
            window.location = "../logedin.php";
        </script>
        <?php
    }
}
?>