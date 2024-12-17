<?php
// Esse arquivo espera receber uma imagem e uma imagem e sua respectiva instituição para, então, retornar se ela está cadastrada ou não
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_FILES['imagem'])) {

        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $image = $_FILES['imagem'];
        $temp = $image['tmp_name'];

        if (is_uploaded_file($temp) && exif_imagetype($temp)) {
            try {
                $script = './alpr_service.sh';
                $command = escapeshellcmd("$script placabrasil.jpg");

                $output = shell_exec($command);

                $response = json_decode($output);

                if(isset($response['error'])){
                    $response = [
                        "status" => "error",
                        "message" => "Imagem não encontrada"
                    ];
                }else{
                    $response = [
                        "status" => "success",
                        "id" => $id,
                        "alpr_output" => $output, // Saída do OpenALPR
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    "status" => "error",
                    "message" => addslashes($e->getMessage())
                ];
            } finally {
                @unlink($temp);
            }
        } else {
            $response = ["status" => "error", "message" => "Falha ao processar o arquivo enviado"];
        }
    } else {
        $response = ["status" => "error", "message" => "Dados incompletos"];
    }
} else {
    $response = ["status" => "error", "message" => "Método não permitido"];
}

echo json_encode($response);
exit;
?>


