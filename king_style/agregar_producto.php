<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success"=>false, "message"=>"Error de conexión a la base de datos"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $nombre = $conn->real_escape_string($_POST['nombre'] ?? '');
    $categoria = $conn->real_escape_string($_POST['categoria'] ?? '');
    $descripcion = $conn->real_escape_string($_POST['descripcion'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $imagenPath = '';

    if(!empty($_FILES['imagen']['name'])){
        $directorio = 'imgProductos/';
        if(!is_dir($directorio)) mkdir($directorio,0777,true);

        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaArchivo = $directorio . time() . '_' . $nombreArchivo;
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
        $permitidos = ['jpg','jpeg','png','gif','webp'];

        if(in_array($tipoArchivo,$permitidos)){
            if(move_uploaded_file($_FILES['imagen']['tmp_name'],$rutaArchivo)){
                $imagenPath = $rutaArchivo;
            } else {
                echo json_encode(["success"=>false,"message"=>"Error al subir la imagen"]);
                exit;
            }
        } else {
            echo json_encode(["success"=>false,"message"=>"Formato de imagen no permitido"]);
            exit;
        }
    }

    $sql = "INSERT INTO productos (nombre,categoria,descripcion,precio,stock,imagen)
            VALUES ('$nombre','$categoria','$descripcion',$precio,$stock,'$imagenPath')";

    if($conn->query($sql)){
        echo json_encode(["success"=>true,"message"=>"Producto agregado correctamente"]);
    } else {
        echo json_encode(["success"=>false,"message"=>"Error al agregar: ".$conn->error]);
    }
} else {
    echo json_encode(["success"=>false,"message"=>"Método no permitido"]);
}

$conn->close();
