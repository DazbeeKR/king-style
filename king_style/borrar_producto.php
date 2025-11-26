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

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $res = $conn->query("SELECT imagen FROM productos WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (file_exists($row['imagen'])) unlink($row['imagen']);
    }
    $sql = "DELETE FROM productos WHERE id = $id";
    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Producto eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar producto"]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Solicitud inválida"]);
$conn->close();
?>