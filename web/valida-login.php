<html>
    TODO
</html>

<?php
include('connectionFactory.php');

if (!isset($_POST['email']) || !isset($_POST['senha'])) {
?>
    <script>
        alert("Email ou senha não foram informados!")
        window.history.back();
    </script>
    <?php
    die;
}

if (empty($_POST['email']) || empty($_GET['senha'])) {
    ?>
    <script>
        alert("Email ou senha não foram informados!")
        window.history.back();
    </script>
    <?php
    die;
}

try {

$conn = getConnection();
$user = $_POST['email'];
$password = $_POST['senha'];

$sql = 'SELECT * FROM Administrador WHERE user = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user);
$stmt->execute();
$resultado = $stmt->get_result();


    if ($resultado->num_rows > 0) {
        $rows = $resultado->fetch_assoc();
        if ($rows['senha'] === $password) {
    ?>
            <script>
                alert("Funcionou")
                console.log("Funcionou")
            </script>
        <?php
        } else {
        ?>
            <script>
                alert("Senha errada")
                console.log("Senha errada")
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            alert("Usuário não existe")
            console.log("Usuário não existe")
        </script>
<?php
    }
} catch (Exception $e) {
    ?>
    <script>console.log(<?php addslashes($e)?>)</script>
    <?php
}


?>