<html>
TODO

</html>

<?php
session_set_cookie_params(['httponly' => true]);

session_start();

session_regenerate_id(true);

$_SESSION['logged_in'] = false;

include('connectionFactory.php');

if (!isset($_POST['email']) || !isset($_POST['senha']) || !isset($_POST['administrador'])) { //Caso verdadeiro o código volta a página ou morre depois do if
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

    if ($_POST['administrador'] == 'adm') {
        $sql = 'SELECT * FROM Administrador WHERE user = ?';
    } else {
        $sql = 'SELECT * FROM Instituicao WHERE email = ?';
    }


    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $resultado = $stmt->get_result();


    if ($resultado->num_rows <= 0) { //Caso verdadeiro o código volta a página ou morre depois do if
    ?>
        <script>
            alert("Usuário/Instituição não existe")
            console.log("Usuário não existe")
            window.history.back();
        </script>
    <?php
        die();
    }

    $rows = $resultado->fetch_assoc();

    if (password_verify($password, $rows['senha'])) {

        $_SESSION['logged_in'] = true;
        $_SESSION['nome'] = $rows['nome'];
        $_SESSION['email'] = $rows['email'];

        if ($_POST['administrador'] == 'adm') {
            $_SESSION['ID'] = $rows['ID'];
            $_SESSION['instituicao_ID'] = $rows['instituicao'];
            $_SESSION['nivelAcesso'] = $rows['nivelDeAcesso'];
        }else {
            $_SESSION['instituicao_ID'] = $rows['ID'];
            $_SESSION['documento'] = $rows['doc'];
        }


    ?>
        <script>
            alert("Funcionou")
            console.log("Funcionou")
            window.history.back();
        </script>
    <?php

    } else { //Caso verdadeiro o código volta a página ou morre depois do else
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
        alert("Ocorreu uma exceção<?php addslashes($e) ?>!!")
        console.log(<?php addslashes($e) ?>)
        // window.history.back();
    </script>
<?php
    echo addslashes($e);
}


?>