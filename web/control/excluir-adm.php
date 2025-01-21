<?php
include_once "connectionFactory.php";
session_start();

if (!isset($_GET['id'])) {
?>

    <script>
        alert("ID do carro não informado!")
        window.history.back()
    </script>
<?php
}

if (!isset($_SESSION['instituicao']) || $_SESSION['instituicao'] !== true || !isset($_SESSION['instituicao_ID'])) {
?>
    <script>
        alert("Você precisa estar logado como uma instituição para isso!");
        window.history.back();
    </script>
    <?php
    die;
}

try {
    $id = intval($_GET['id']);
    $idInst = $_SESSION['instituicao_ID'];
    $conn = getConnection();

    $sqlCheck = "SELECT * FROM Administrador WHERE id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['instituicao'] !== $idInst) {
            ?>
            <script>
                alert("Você não tem permissão para excluir esse administrador")
                window.history.back();
            </script>
        <?php
        die;
        }
        $sqlDelete = "DELETE FROM Administrador WHERE id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);

        if ($stmtDelete->execute()) {
    ?>
            <script>
                alert("Administrador excluído com sucesso")
                window.history.back();
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Erro ao excluir Administrador!")
                window.history.back();
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            alert("Adm não encontrado!")
            window.history.back();
        </script>
    <?php
    }
} catch (Exception $e) {
    ?>
    <script>
        alert("<?php echo $e->getMessage() ?>")
    </script>
<?php
}


?>