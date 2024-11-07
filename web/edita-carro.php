<?php
include_once "connectionFactory.php";
$conn = getConnection();
if (isset($_POST['placa'])) {
    $placa = $_POST['placa'];
    $proprietario = $_POST['proprietario'];

    $sql = "UPDATE Carro SET placa = '$placa', proprietario = '$proprietario' WHERE id = " . $_GET['id'];
    if ($conn->query($sql) === TRUE) {
?>
        <script>
            alert("Registro atualizado com sucesso!");
            window.location = "logedin.php";
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
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar carro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h2>Editar carro</h2>

    <?php
    if (isset($_GET['id'])) {
        $sql = "SELECT * FROM Carro WHERE id = " . $_GET['id'];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }else{
        ?>
        <script>window.history.back()</script>
        <?php
    }
    ?>
    <h2>testando essa bosta</h2>
    <form action="edita-carro.php?id=<?php echo $_GET['id'] ?>" method="POST">
        <div class="mb-3 mt-3">
            <label for="placa" class="form-label">Placa:</label>
            <input type="text" class="form-control" id="placa" placeholder="Informe a placa" name="placa" value="<?php echo $row['placa']?>">
        </div>

        <div class="mb-3 mt-3">
            <label for="proprietario" class="form-label">Proprietario:</label>
            <input type="text" class="form-control" id="proprietario" placeholder="Informe o prorpietario" name="proprietario" value="<?php echo $row['proprietario']?>">
        </div>
        <div class="mb-3 mt-3">
            <input class="btn btn-primary " type="submit" value="Salvar">
            <input class="btn btn-warning" type="reset" value="Limpar">
        </div>
    </form>
</body>

</html>