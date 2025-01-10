<?php
include_once "../connectionFactory.php";

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
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
}else{
    ?>
    
    <script>
    alert("ID do carro não informado!")
    window.history.back()</script>
    <?php
}
?>