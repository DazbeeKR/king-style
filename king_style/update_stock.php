<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit;
}

if (isset($_POST['id']) && isset($_POST['stock'])) {
    $id = intval($_POST['id']);
    $stock = intval($_POST['stock']);
    $sql = "UPDATE productos SET stock = $stock WHERE id = $id";

    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Stock actualizado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar"]);
    }
    exit;
}

if (isset($_POST['ids']) && isset($_POST['stocks'])) {
    $ids = $_POST['ids'];
    $stocks = $_POST['stocks'];
    $updated = [];

    for ($i = 0; $i < count($ids); $i++) {
        $id = intval($ids[$i]);
        $stock = intval($stocks[$i]);
        $sql = "UPDATE productos SET stock = $stock WHERE id = $id";
        if ($conn->query($sql)) {
            $updated[] = ["id" => $id, "stock" => $stock];
        }
    }

    echo json_encode(["success" => true, "message" => "Todos los stocks fueron actualizados.", "updated" => $updated]);
    exit;
}

echo json_encode(["success" => false, "message" => "Solicitud inválida."]);
$conn->close();
?>
