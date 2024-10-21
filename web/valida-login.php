<html>
    TODO
</html>

<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);
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
            $_SESSION['logged_in'] = true;
            $_SESSION['ID_adm'] = $resultado['ID'];
            $_SESSION['nome'] = $resultado['nome']
    ?>
            <script>
                alert("Funcionou")
                console.log("Funcionou")
            </script>
        <?php
        
        } else {
            $_SESSION['logged_in'] = false;
        ?>
            <script>
                alert("Senha errada")
                console.log("Senha errada")
            </script>
        <?php
        }
    } else {
        $_SESSION['logged_in'] = false;
        ?>
        <script>
            alert("Usuário não existe")
            console.log("Usuário não existe")
        </script>
<?php
    }
} catch (Exception $e) {
    $_SESSION['logged_in'] = false;
    ?>
    <script>console.log(<?php addslashes($e)?>)</script>
    <?php
}


?>