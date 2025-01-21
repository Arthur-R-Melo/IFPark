<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
    header("Location: login.html");
    exit();
}

include('control/connectionFactory.php');
$sql = "SELECT * FROM Carro WHERE instituicao = " . $_SESSION['instituicao_ID'];
$conn = getConnection();
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Carros</title>
    <link rel="icon" href="images/logo_ifpark_icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">    
</head>

<body>
<header>
        <img src="images/ifpark_logoBranco_TXT.png" alt="IfPark Logo">
    </header>

    <nav>
        <ul>
            <li><a href="logedin.php">INÍCIO</a></li>
            <li><a href="contato.html">CONTATO</a></li>
            <li><a href="cadastroCarro.html">CADASTRAR NOVO CARRO</a></li>
        </ul>
    </nav>
    <script>
        function exclude(id) {
            if (confirm("Realmente deseja excluir esse carro?")) {
                window.location.href = "control/excluir_carro.php?idCarro=" + id;
            }
        }
    </script>
    
    <br>
    <h1 style="text-align: center;">CARROS CADASTRADOS</h1>
    <h3 style="text-align: center;"><?php echo $_SESSION['instituicaoNome']?></h3>

    <?php
    if ($resultado->num_rows > 0) {
    ?>
        <table class="table table-striped">
            <thead>
                <th>Proprietario</th>
                <th>Placa</th>
                <th>Editar</th>
                <th>Excluir</th>
            </thead>


            <tbody>
                <?php
                while ($row = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['proprietario'] ?></td>
                        <td><?php echo $row['placa'] ?></td>
                        <td><button type="button" class="btn btn-secondary" onclick="window.location.href = 'edita-carro.php?id='+<?php echo $row['id'] ?>">Editar</button></td>
                        <td><button type="button" class="btn btn-outline-danger" onclick="exclude(<?php echo $row['id'] ?>)">Excluir</button></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    ?>
</body>

</html>