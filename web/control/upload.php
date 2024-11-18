<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $target_dir = "fotos/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Cria o diretório, se não existir
    }
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica se o arquivo é uma imagem
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "É uma imagem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Não é imagem.";
        $uploadOk = 0;
    }

    // Verifica o tamanho do arquivo
    if ($_FILES["file"]["size"] > 50000000) { // 50MB máximo
        echo "Arquivo grande demais.";
        $uploadOk = 0;
    }

    // Permite certos formatos de arquivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Verifica se $uploadOk está definido como 0 por algum erro
    if ($uploadOk == 0) {
        echo "Não teve upload.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "o arquivo " . htmlspecialchars(basename($_FILES["file"]["name"])) . " ta la.";
        } else {
            echo "Erro no upload";
        }
    }
} else {
    echo "Não Deu.";
}
?>
