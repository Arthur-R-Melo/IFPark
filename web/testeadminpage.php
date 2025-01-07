<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == FALSE) {
    header("Location: login.html");
    exit();
}

include('connectionFactory.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">    
</head>
<body>
    <header>
        <img src="images/ifpark_logoBranco_TXT.png" alt="IfPark Logo">
        <?php echo $_SESSION['documento'];?>
    </header>

    <nav>
        <ul>
            <li><a href="index.html">INÍCIO</a></li>
            <li><a href="contato.html">CONTATO</a></li>
            <li><a href="cadastroCarro.html">CADASTRAR NOVO CARRO</a></li>
        </ul>
    </nav>

    <main class="container my-5">
        <!-- Seção de dados da empresa -->
        <section class="mb-5">
            <h2 class="mb-3"><?php echo $_SESSION['instituicaoNome'];?></h2>
            <form>
                <div class="mb-3">
                    <label for="nomeEmpresa" class="form-label">Nome da Empresa</label>
                    <input type="text" class="form-control" id="nomeEmpresa" placeholder=<?php echo $_SESSION['instituicaoNome'];?>>
                </div>
                <div class="mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" placeholder=<?php echo $_SESSION['documento'];?>>
                </div>
                <div class="mb-3">
                    <label for="endereco" class="form-label">Email</label>
                    <input type="text" class="form-control" id="endereco" placeholder=<?php echo $_SESSION['email'];?>>
                </div>
                
                <button type="submit" class="btn btn-success">Salvar</button>
            </form>
        </section>

        <!-- Seção de funcionários -->
        <section>
            <h2 class="mb-3">Funcionários</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>João Silva</td>
                        <td>Gerente</td>
                        <td>joao.silva@empresa.com</td>
                        <td>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Maria Oliveira</td>
                        <td>Assistente</td>
                        <td>maria.oliveira@empresa.com</td>
                        <td>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-success">Adicionar Funcionário</button>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 IfPark. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
   
    
</body>
</html>
