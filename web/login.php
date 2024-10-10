<?php
include('connectionFactory.php');

$conn = getConnection();

$user = isset($_GET['user']) ? $_GET['user'] : '';
$password = isset($_GET['senha']) ? $_GET['senha'] : '';

$sql = 'SELECT * FROM administrador WHERE user = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user);
$stmt->execute();
$resultado = $stmt->get_result();

header('Content-Type: application/json');
$result;

try {

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        if ($row['senha'] == $password) {
            $result = [
                'response' => 'true',
                'nome' => $row['nome'],
                'acessLevel' => $row['nivelDeAcesso'],
                'instituicao' => $row['instituicao']
            ];
        } else {
            $result = [
                'response' => 'false'
            ];
        }
    } else {
        $result = [
            'response' => 'false'
        ];
    }
} catch (Exception $e) {
    $result = [
        'response' => 'false',
        'error' => $e->getMessage()
    ];
} finally {
    echo json_encode($result);
}



