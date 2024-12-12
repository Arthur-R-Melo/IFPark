<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFPark - Cadastro de Conta</title>
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
            <li><a href="index.html">INÍCIO</a></li>
            <li><a href="contato.html">CONTATO</a></li>
            <li><a href="login.html">LOGIN</a></li>
        </ul>
    </nav>

    <div class="container" id="form-container">
        <h1 id="h1-login">Cadastro de Instituição</h1>
        <br>
        <form action="" onsubmit="//script que roda antes do action" method="POST">
            <div class="mb-3">
                <label for="nomeInst" class="form-label">Nome da Instituição</label>
                <input type="text" class="form-control" name="nomeInst" id="nomeInst" placeholder="Insira o nome da instituição">
            </div>
            <div class="mb-3">
                <label for="emailInst" class="form-label">Email da instituição</label>
                <input type="email" name="emailInst" id="emailInst" class="form-control" placeholder="Insira o email da instituição">
            </div>
            
        </form>
    </div>
</body>

</html>