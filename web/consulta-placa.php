<?php
include('connectionFactory.php');

if (!(isset($_GET['placa']) && !empty($_GET['placa']))) {
    die;
}

$placa = $_GET['placa'];
$conn = getConnection();

$sql = 'SELECT * FROM Carro WHERE placa = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $placa);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');

$data;

if ($result->num_rows>0) {
    $data = array(
        "existe" => "true"
    );
}else {
    $data = array(
        "existe" => "false"
    );
}
?>
<script>
    alert("Ta rodando certinho")
    console.log(<?php $result->num_rows>0 ?>)
</script>
<?php
echo json_encode($data);
?>