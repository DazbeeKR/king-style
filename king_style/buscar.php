<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir búsqueda
$busqueda = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : "";

// Consultar productos que coincidan en nombre
$sql = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%'";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
</head>
<body>
    <h2>Resultados de: "<?= htmlspecialchars($busqueda) ?>"</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($producto = $resultado->fetch_assoc()) { ?>
            <div class="card">
                <a href="producto.php?id=<?= $producto['id'] ?>">
                    <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen del producto">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                    <p><strong>$<?= $producto['precio'] ?></strong></p>

                    <!-- Botón agregar al carrito -->
                    <form action="agregar_carrito.php" method="POST">
                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                        <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
                        <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                        <button type="submit">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php else: ?>
        <p>No se encontraron productos con esa búsqueda.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">Volver al inicio</a>
</body>
</html>
