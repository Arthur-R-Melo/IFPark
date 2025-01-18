<?php
include('../connectionFactory.php');
session_start();

if (!isset($_SESSION['instituicao']) || $_SESSION['instituicao'] !== true || !isset($_SESSION['instituicao_ID'])) {
?>
    <script>
        alert("Você precisa estar logado como uma instituição para isso!");
        window.history.back();
    </script>
<?php
    die;
}
if (!isset($_POST['nome']) || !isset($_POST['email']) || !isset($_POST['documento'])) {
?>
    <script>
        alert("Alguma informação está ausente!");
        window.history.back();
    </script>
<?php
    die;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$documento = $_POST['documento'];
$id = $_SESSION['instituicao_ID'];

$sql = 'UPDATE Instituicao SET nome = ?, email = ?, documento = ? WHERE ID = ?';
$conn = getConnection();

$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $nome, $email, $documento, $id);

if ($stmt->execute()) {
    $_SESSION['instituicaoNome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['documento'] = $documento;
?>
    <script>
        alert("Registro atualizado com sucesso!");
        window.history.back();
    </script>
<?php
} else {
?>
    <script>
        alert("Erro ao atualizar registro!");
        window.history.back();
    </script>
<?php
}

$stmtUpdate->close();
$stmtCheck->close();
$conn->close();
?>
<script>
    window.history.back();
</script>
<?php
die;
?>