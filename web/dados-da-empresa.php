<?php
include_once "connectionFactory.php";
session_start();
//Exibir os dados da empresa apenas, a atualização desses dados (tanto no bd quanto na sessão) deve ser responsabilidade de outro arquivo


if (!isset($_SESSION['instituicao']) || $_SESSION['instituicao'] !== true || !isset($_SESSION['instituicao_ID'])) {
?>
    <script>
        alert("Você precisa estar logado como uma instituição para isso!");
        window.history.back();
    </script>
<?php
    die();
}

$instiID = $_SESSION['instituicao_ID'];
$conn = getConnection();
$sql = "SELECT * FROM Instituicao WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $instiID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
?>
    <script>
        alert("Erro: Instituição não encontrada!");
        window.history.back();
    </script>
<?php
    exit;
}

$row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IF Park - Dados da Empresa</title>
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
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6 d-flex justify-content-center align-items-center">
                <form action="" onsubmit="return validarFormulario(event)" method="post">
                    <div class="mb-3 mt-3">
                        <label for="nome" class="form-label">Nome da instituição</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['nome'] ?>">
                        <div id="error-nome" style="color: red; display: none;">Por favor, preencha este campo.</div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email da Instituição</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
                        <div id="error-email" style="color: red; display: none;">Por favor, insira um email válido.</div>
                    </div>

                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="documento" class="form-control" id="documento" placeholder=<?php echo $row['doc']; ?>>
                        <div id="error-documento" style="color: red; display: none;">Por favor, insisra um documento em formato válido contendo apenas números</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <input type="submit" value="Cadastrar" class="btn btn-success">
                        <input type="reset" value="Limpar" class="btn btn-warning">
                    </div>
                </form>
            </div>
            <div class="col-6 d-flex justify-content-center align-items-center">
                <h1>Direita</h1>
            </div>
        </div>
    </div>
</body>

<script>
    function validarFormulario(event) {
        document.getElementById('form-instituicao').addEventListener('submit', function(event) {
            let valid = true;

            // Nome
            const nome = document.getElementById('nome');
            const errorNome = document.getElementById('error-nome');
            if (nome.value.trim() === '') {
                errorNome.style.display = 'block';
                valid = false;
            } else {
                errorNome.style.display = 'none';
            }

            // Email
            const email = document.getElementById('email');
            const errorEmail = document.getElementById('error-email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                errorEmail.style.display = 'block';
                valid = false;
            } else {
                errorEmail.style.display = 'none';
            }

            // Documento
            const documento = document.getElementById('documento');
            const errorDocumento = document.getElementById('error-documento');
            const documentoRegex = /^[0-9]+$/; // Apenas números
            if (!documentoRegex.test(documento.value.trim())) {
                errorDocumento.style.display = 'block';
                valid = false;
            } else {
                errorDocumento.style.display = 'none';
            }

            // Impedir envio se houver erros
            if (!valid) {
                event.preventDefault();
                return false;
            }
            return true;
        });
    }
</script>

</html>