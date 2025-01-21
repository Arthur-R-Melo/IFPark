<?php
include_once "connectionFactory.php";
session_start();

if (!isset($_GET['idAdm'])) {
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

$id = intval($_GET['idAdm']);
$idInst = $_SESSION['instituicao_ID'];
$conn = getConnection();

$sqlCheck = "SELECT id FROM Administrador WHERE id = ? AND instituica0 = ?";
$stmtCheck = $conn->prepare($sql);
$stmtCheck->bind_param("ii", $id, $idInst);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows > 0) {
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
    
}else {
    ?>
        <script>
            alert("Você não tem permissão para excluir esse administrador")
            window.history.back();
        </script>
        <?php
}
?>