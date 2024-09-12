<?php
include('connectionFactory.php');

$conn = getConnection();

$user = isset($_GET['user']) ? $_GET['user']:'';
$password = isset($_GET['senha']) ? $_GET['senha']:'';

$sql = 'SELECT * FROM administrador WHERE usuario = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user);
$stmt->execute();
$resultado = $stmt->get_result();

header('Content-Type: application/json');
$result;

if($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    if($row['Senha'] == $password) {
        $result = [
            'response' => 'true',
            'nome' => $row['Nome'],
            'acessLevel' => $row['NivelDeAcesso'],
            'instituicao' => $row['InstituicaoID']
        ];
    }else {
        $result = [
            'response' => 'false'
        ];
    }
}else {
    $result = [
        'response' => 'false'
    ];
}

echo json_encode($result);

