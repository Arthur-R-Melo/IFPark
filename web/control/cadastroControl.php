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

try {
    $conn = getConnection();
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