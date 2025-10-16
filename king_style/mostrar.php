<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$resultado = $conn->query("SELECT id, nombre, precio, imagen FROM productos ORDER BY id LIMIT 6");
?>

<head>
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
</head>

<body>

<?php
session_start();
if (isset($_SESSION['mensaje'])) {
    echo "<p style='color:green;'>" . $_SESSION['mensaje'] . "</p>";
    unset($_SESSION['mensaje']); // lo borramos para que no quede fijo
}
?>


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
  </div>
</div>
</body>
