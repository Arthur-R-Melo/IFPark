<!DOCTYPE html>
<html lang="pt-br">
<?php
    session_start();

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false) {
        header("Location: login.php");
        exit();
    }

    include('connectionFactory.php');
    $sql = "SELECT * FROM Carro WHERE instituicao = ".$_SESSION['instituicao_ID'];
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Carros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script>
        function exclude(id) {
            if (confirm("Realmente deseja excluir esse carro?")) {
                window.location.href="control/excluir_carro.php?id"+id;
            }
        }
    </script>
    <h1 style="text-align: center;">Carros cadastrados</h1>

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

        </table>
        <tbody>
            <?php
            while ($row = $resultado->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['proprietario']?></td>
                    <td><?php echo $row['placa']?></td>
                    <td><a href="">Editar</a></td>
                    <td><a onclick="exclude(<?php echo $row['id']?>)">Excluir</a></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <?php
    }
    ?>
</body>
</html>