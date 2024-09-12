<?php
include('connectionFactory.php');

$conn = getConnection();

$user = isset($_GET['user']) ? $_GET['user']:'';
$password = isset($_GET['senha']) ? $_GET['senha']:'';

$sql = 'SELECT * FROM administrador WHERE usuario = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
$result;

if($result->num_rows > 0) {
    $row = $stmt->fetch();
    if($row['senha'] == $password) {
        $result = [
            'response' => 'true',
            'nome' => $row['nome'],
            'acessLevel' => $row['niveldeacesso'],
            'instituicao' => $row['instituicaoid']
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

