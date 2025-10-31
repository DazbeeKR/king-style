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
$sql = "SELECT * FROM productos 
        WHERE nombre LIKE '%$busqueda%' 
        OR categoria LIKE '%$busqueda%'";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
      <style>
/* === PRODUCTOS / CARDS === */
.productos-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.productos-row .card {
  flex: 1 1 calc(33.333% - 20px);
  min-width: 220px;
  max-width: 320px;
  display: flex;
  flex-direction: column;
  border: none;
  box-shadow: 0 6px 10px rgba(0,0,0,0.05);
  transition: transform 0.2s ease-in-out;
}

.productos-row .card:hover {
  transform: scale(1.04);
}

/* Imágenes responsivas */
.productos-row .card .card-img-top {
  width: 100%;
  height: auto;
  max-height: 250px;
  object-fit: cover;
  object-position: center;
  border-radius: 6px 6px 0 0;
  transition: transform 0.3s ease;
}

.productos-row .card .card-img-top:hover {
  transform: scale(1.05);
}

/* Tablet: 2 por fila */
@media (max-width: 992px) {
  .productos-row .card {
    flex: 1 1 calc(50% - 20px);
  }
  .productos-row .card .card-img-top {
    max-height: 200px;
  }
}

/* Celular: 1 por fila */
@media (max-width: 576px) {
  .productos-row .card {
    flex: 1 1 100%;
  }
  .productos-row .card .card-img-top {
    max-height: 160px;
  }
}
  </style>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navegacion/barra_navegacion.php' ?>

    <h2>Resultados de: "<?= htmlspecialchars($busqueda) ?>"</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <div class="container mt-4">
  <div class="productos-row">
<?php while ($producto = $resultado->fetch_assoc()) { ?>
  <div class="card">
    <a href="producto.php?id=<?= $producto['id'] ?>">
      <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen del producto">
    </a>
    <div class="card-body">
      <h5 class="card-title"><?= $producto['nombre'] ?></h5>
      <p><strong>$<?= $producto['precio'] ?></strong></p>

<form action="agregar_carrito.php" method="POST">
  <input type="hidden" name="id" value="<?= $producto['id'] ?>">
  <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
  <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
  <input type="hidden" name="imagen" value="<?= $producto['imagen'] ?>">
  <button type="submit">Agregar al carrito</button>
</form>
    </div>
  </div>
<?php } ?>
    <?php else: ?>
        <p>No se encontraron productos con esa búsqueda.</p>
    <?php endif; ?>

    <br>
</body>
</html>
