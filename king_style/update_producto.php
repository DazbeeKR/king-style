<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión con la base de datos."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = intval($_POST['id'] ?? 0);
    $nombre      = $conn->real_escape_string($_POST['nombre'] ?? '');
    $categoria   = $conn->real_escape_string($_POST['categoria'] ?? '');
    $descripcion = $conn->real_escape_string($_POST['descripcion'] ?? '');
    $precio      = floatval($_POST['precio'] ?? 0);
    $stock       = intval($_POST['stock'] ?? 0);
    $nuevaImagen = "";

    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "ID inválido."]);
        exit;
    }

    if (!empty($_FILES['imagen']['name'])) {
        $directorio = "imgProductos/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaArchivo = $directorio . time() . "_" . $nombreArchivo;
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($tipoArchivo, $permitidos)) {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo)) {
                $nuevaImagen = $rutaArchivo;
            } else {
                echo json_encode(["success" => false, "message" => "Error al subir la imagen."]);
                exit;
            }
        } else {
            echo json_encode(["success" => false, "message" => "Formato de imagen no permitido."]);
            exit;
        }
    }

    if ($nuevaImagen !== "") {
        $sql = "UPDATE productos 
                SET nombre='$nombre', categoria='$categoria', descripcion='$descripcion', 
                    precio=$precio, stock=$stock, imagen='$nuevaImagen'
                WHERE id=$id";
    } else {
        $sql = "UPDATE productos 
                SET nombre='$nombre', categoria='$categoria', descripcion='$descripcion', 
                    precio=$precio, stock=$stock
                WHERE id=$id";
    }

    if ($conn->query($sql)) {
        $response = [
            "success" => true,
            "message" => "Producto actualizado correctamente.",
        ];
        if ($nuevaImagen !== "") $response["imagen"] = $nuevaImagen;
        echo json_encode($response);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

$conn->close();
?>
