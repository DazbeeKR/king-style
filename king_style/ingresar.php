<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];

    $imagen = "";
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $carpetaDestino = "imgProductos/";
        

        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaDestino = $carpetaDestino . uniqid() . "_" . $nombreArchivo;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            $imagen = $rutaDestino;
        } else {
            echo "Error al subir la imagen.";
        }
    }


    $sql = "INSERT INTO productos (nombre, precio, categoria, descripcion, imagen) VALUES ('$nombre', '$precio', '$categoria', '$descripcion', '$imagen')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Producto agregado con éxito</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
</head>
<body>
    <h2>Agregar Producto</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Categorias:</label><br>
        <input type="text" name="categoria" required><br><br>

        <label>Descripcion:</label><br>
        <input type="text" name="descripcion" required><br><br>

        <label>Precio:</label><br>
        <input type="number" name="precio" step="0.01" required><br><br>

        <label>Imagen:</label><br>
        <input type="file" name="imagen" accept="image/*" required><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
