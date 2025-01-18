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

    <br><br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                <div style="width: 80%; max-width: 600px;">
                    <h1 id="h1-login" class="mb-4 text-center">Informações da empresa</h1>

                    <form action="control/atualiza-empresa.php" onsubmit="return validarFormulario(event)" method="post">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da instituição</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['nome'] ?>">
                            <div id="error-nome" style="color: red; display: none;">Por favor, preencha este campo.</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email da Instituição</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
                            <div id="error-email" style="color: red; display: none;">Por favor, insira um email válido.</div>
                        </div>

                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $row['doc']; ?>">
                            <div id="error-documento" style="color: red; display: none;">Por favor, insira um documento em formato válido contendo apenas números</div>
                        </div>

                        <div class="d-grid gap-2">
                            <input type="submit" value="Salvar" class="btn btn-success">
                            <input type="reset" value="Restaurar" class="btn btn-warning">
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                <div class="row">
                    <!-- Card Plano Essencial -->
                    <div class="col-12 col-md-4 mb-3">
                         <div class="card d-flex flex-column h-100" style="max-width: 350px;">
                            <img src="imagem-plano-essencial.jpg" class="card-img-top" alt="Plano Essencial">
                            <div class="card-body">
                                <h5 class="card-title">Plano Essencial</h5>
                                <h6 class="card-subtitle mb-2 text-muted">R$ 199/mês</h6>
                                <p class="card-text">
                                    - Controle de até 1 portão<br>
                                    - 50 registros de placas<br>
                                    - Suporte básico via email
                                </p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mensagemModal">Escolher</button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Plano Avançado -->
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card d-flex flex-column h-100" style="max-width: 350px;">
                            <img src="imagem-plano-avancado.jpg" class="card-img-top" alt="Plano Avançado">
                            <div class="card-body">
                                <h5 class="card-title">Plano Avançado</h5>
                                <h6 class="card-subtitle mb-2 text-muted">R$ 349/mês</h6>
                                <p class="card-text">
                                    - Controle de até 3 portões<br>
                                    - 200 registros de placas<br>
                                    - Suporte via email e telefone<br>
                                    - Atualizações automáticas
                                </p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mensagemModal">Escolher</button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Plano Profissional -->
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card d-flex flex-column h-100" style="max-width: 350px;">
                            <img src="imagem-plano-profissional.jpg" class="card-img-top" alt="Plano Profissional">
                            <div class="card-body">
                                <h5 class="card-title">Plano Profissional</h5>
                                <h6 class="card-subtitle mb-2 text-muted">R$ 599/mês</h6>
                                <p class="card-text">
                                    - Controle de portões ilimitados<br>
                                    - Registros de placas ilimitados<br>
                                    - Suporte 24/7<br>
                                    - Relatórios personalizados<br>
                                    - Integração com sistemas
                                </p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mensagemModal">Escolher</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mensagemModal" tabindex="-1" aria-labelledby="mensagemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mensagemModalLabel">Atenção</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        A funcionalidade de escolha do plano ainda não foi implementada. Infelizmente ela foge do escopo do minimo produto viável!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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