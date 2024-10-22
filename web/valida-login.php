<html>
TODO

</html>

<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

$_SESSION['logged_in'] = false;

include('connectionFactory.php');

if (!isset($_POST['email']) || !isset($_POST['senha']) || empty($_POST['email']) || empty($_GET['senha'])) {//Caso verdadeiro o código volta a página ou morre depois do if
?>
    <script>
        alert("Email ou senha não foram informados!")
        window.history.back();
    </script>
    <?php
    die();
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


    if ($resultado->num_rows <= 0) {//Caso verdadeiro o código volta a página ou morre depois do if
    ?>
        <script>
            alert("Usuário não existe")
            console.log("Usuário não existe")
            window.history.back();
        </script>
    <?php
    die();
    }

    $rows = $resultado->fetch_assoc();

    if ($rows['senha'] === $password) {

        $_SESSION['logged_in'] = true;
        $_SESSION['ID_adm'] = $resultado['ID'];
        $_SESSION['nome'] = $resultado['nome'];
        $_SESSION['instituicao_ID'] = $resultado['instituicao'];
        $_SESSION['nivelAcesso'] = $resultado['nivelDeAcesso'];
        $_SESSION['email'] = $resultado['email'];
    ?>
        <script>
            alert("Funcionou")
            console.log("Funcionou")
            window.history.back();
        </script>
    <?php

    } else {//Caso verdadeiro o código volta a página ou morre depois do else
    ?>
        <script>
            alert("Senha errada")
            console.log("Senha errada")
            window.history.back();
        </script>
    <?php
    die();
    }
} catch (Exception $e) {
    ?>
    <script>
        alert("Ocorreu uma exceção!!")
        console.log(<?php addslashes($e) ?>)
        window.history.back();
    </script>
<?php
}


?>