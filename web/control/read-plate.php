<?php
// Esse arquivo espera receber uma imagem e uma imagem e sua respectiva instituição para, então, retornar se ela está cadastrada ou não
header('Content-Type: aplication/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_FILES['imagem'])) {
        
        $id = $_POST['id'];
        $image = $_FILES['imagem'];
        $temp = $image['tmp_name'];

        if (is_uploaded_file($temp)) {
            try {
                $command = escapeshellcmd("alpr -c br -n 5". escapeshellarg($temp));

                $output = shell_exec($command);
    
                $response = [
                    "status" => "success",
                    "id" => $id,
                    "alpr_output" => $output, // Saída do OpenALPR
                ];
            } catch (Exception $e) {
                $response = [
                    "status" => "error",
                    "message" => addslashes($e->getMessage())
                ];
            }
            

        }else {
            $response = ["status" => "error", "message" => "Falha ao processar o arquivo enviado"];
        }

    }else {
        $response = ["status" => "error", "message" => "Dados incompletos"];
    }
}else{
    $response = ["status" => "error", "message" => "Método não permitido"];
}

echo json_encode($response)
?>
