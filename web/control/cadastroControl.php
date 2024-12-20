<?php
include("../connectionFactory.php");

if (!(isset($_POST['nomeInst']) && isset($_POST['emailInst']) && isset($_POST['document']) && isset($_POST['password']))) {
?>
    <script>
        alert("Alguma informação não foi definida!")
        window.history.back();
    </script>
<?php
    die();
}

if (isEmailInDatabase($email)) {
?>
    <script>
        alert("Email já cadastrado");
        window.history.back();
    </script>
    <?php
    die();
}

try {
    $conn = getConnection();

    $nome = $_POST['nomeInst'];
    $email = $_POST['emailInst'];
    $documento = $_POST['document'];
    $senha = $_POST['password'];

    $hashedPassword = password_hash($senha, PASSWORD_ARGON2I);

    $sql = "INSERT INTO Instituicao (nome, email, doc, senha) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $nome, $email, $documento, $hashedPassword);

    if ($stmt->execute()) {
    ?>
        <script>
            alert("Cadastro realizado com sucesso!");
            window.location.href = "../login.html";
        </script>
    <?php
    } else {
    ?>
        <script>
            alert("O cadastro falhou!");
            window.history.back();
        </script>
    <?php
    }

    $stmt->close();
    $conn->close();
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

function isEmailInDatabase($email)
{
    try {
        $conn = getConnection();
        $sql = "SELECT * FROM Instituicao WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $stmt->close();
            $conn->close();
            return $result->num_rows > 0;
        }else {
            return true;
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
        return true;
    }
}
?>