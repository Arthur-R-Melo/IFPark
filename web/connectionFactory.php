<?php



function getConnection()
{
    include('infoDB.php');
    $host = $config['host'];
    $username = $config['username'];
    $password = $config['password'];
    $database = $config['database'];

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    return $conn;
}

?>