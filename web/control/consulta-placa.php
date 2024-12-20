<?php
include('../connectionFactory.php');

if (isset($_GET['placa']) && isset($_GET['id'])) {
    header('Content-Type: application/json');
    $data = consultaPlaca($_GET['placa'], $_GET['id']);
    echo json_encode($data);
}




function consultaPlaca($placa, $idEmpresa)
{
    try {
        $conn = getConnection();
        $sql = 'SELECT * FROM Carro WHERE placa = ? AND instituicao = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $placa, $idEmpresa);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = array(
                "existe" => "true"
            );
        } else {
            $data = array(
                "existe" => "false"
            );
        }
        return $data;
    } catch (Exception $e) {
        echo $e;
        return array(
            "existe" => "false"
        );
    }
}
