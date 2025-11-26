<?php
$isAjax = $_SERVER['REQUEST_METHOD'] === 'POST';
?>

<?php if (!$isAjax): ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Actualizar Stock - King Style</title>
<link rel="stylesheet" href="style.css">
<style>
body {
    font-family: 'Inter', sans-serif;
    background: #fff;
    margin: 0;
    padding: 30px;
    text-align: center;
    color: #333;
}

.logo-central {
    margin-bottom: 30px;
}
.logo-central img {
    height: 80px;
    filter: brightness(1.2);
}

.contenedor-update {
    max-width: 500px;
    margin: 0 auto;
    padding: 25px;
    background: #fefefe;
    border-radius: 18px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: left;
}

.contenedor-update h2 {
    text-align: center;
    margin-bottom: 25px;
}

.contenedor-update label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
}

.contenedor-update input[type="text"],
.contenedor-update input[type="number"],
.contenedor-update textarea,
.contenedor-update input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 12px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.contenedor-update button {
    background: #000;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    margin-top: 20px;
    width: 100%;
    font-size: 16px;
    transition: 0.3s;
}
.contenedor-update button:hover {
    background: #444;
}

.preview-img {
    display: block;
    margin: 15px auto;
    width: 150px;
    border-radius: 12px;
    object-fit: cover;
}
</style>
</head>
<body>

<div class="logo-central">
    <img src="imgProductos/King_Style.png" alt="Logo King Style">
</div>

<div class="contenedor-update">
    <h2>Actualizar Producto (Prueba Visual)</h2>
    <form id="formUpdate" method="POST" enctype="multipart/form-data">
        <label>ID:</label>
        <input type="number" name="id" value="1">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="Producto de prueba">

        <label>Categoría:</label>
        <input type="text" name="categoria" value="Categoría ejemplo">

        <label>Descripción:</label>
        <textarea name="descripcion">Descripción ejemplo</textarea>

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" value="100">

        <label>Stock:</label>
        <input type="number" name="stock" value="10">

        <label>Imagen:</label>
        <input type="file" name="imagen" id="inputImagen">
        <img class="preview-img" id="previewImagen" src="imgProductos/user-icon.jpg" alt="Imagen actual">

        <button type="button" onclick="actualizarProducto()">Actualizar Producto</button>
        <p id="mensaje" style="text-align:center; font-weight:bold; margin-top:15px;"></p>
    </form>
</div>

<script>
const inputImagen = document.getElementById('inputImagen');
const previewImagen = document.getElementById('previewImagen');
const mensaje = document.getElementById('mensaje');
const formUpdate = document.getElementById('formUpdate');

inputImagen.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImagen.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

function actualizarProducto() {
    const formData = new FormData(formUpdate);
    fetch('update_stock.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        mensaje.textContent = data.message;
        mensaje.style.color = data.success ? 'green' : 'red';
        if (data.success && data.imagen) {
            previewImagen.src = data.imagen;
        }
    })
    .catch(err => {
        mensaje.textContent = 'Error al actualizar.';
        mensaje.style.color = 'red';
        console.error(err);
    });
}
</script>

</body>
</html>
<?php endif; ?>

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
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);

        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaArchivo = $directorio . time() . "_" . $nombreArchivo;
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
        $permitidos = ['jpg','jpeg','png','gif','webp'];

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
            "message" => "Producto actualizado correctamente."
        ];
        if ($nuevaImagen !== "") $response["imagen"] = $nuevaImagen;
        echo json_encode($response);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar: ".$conn->error]);
    }
}

$conn->close();
?>
