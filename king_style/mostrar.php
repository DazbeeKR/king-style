<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);
?>

<body>

<?php
if (isset($_SESSION['mensaje'])) {
    echo "<p style='color:green;'>" . $_SESSION['mensaje'] . "</p>";
    unset($_SESSION['mensaje']);
}
?>

<h2 class="seccion">Últimos productos</h2>
<div class="container mt-4">
  <div class="productos-row">
  <?php
  $ultimos = $conn->query("SELECT id, nombre, precio, imagen FROM productos ORDER BY id DESC LIMIT 4");
  while ($producto = $ultimos->fetch_assoc()) { ?>
    <div class="card">
      <a href="producto.php?id=<?= $producto['id'] ?>">
        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen del producto">
      </a>
      <div class="card-body">
        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
        <p><strong>$<?= number_format($producto['precio'], 2, ',', '.') ?></strong></p>
      </div>
    </div>
  <?php } ?>
  </div>
</div>


<h2 class="seccion">Descuentos del día</h2>
<div class="container mt-4">
  <div class="productos-row">
  <?php

  $seed = date('Ymd');
  $conn->query("SET @seed := $seed");


  $promos = $conn->query("SELECT id, nombre, precio, imagen FROM productos ORDER BY RAND(@seed) LIMIT 4");


  $descuentos_disponibles = [5, 10, 15];

  while ($producto = $promos->fetch_assoc()) {

      $descuento_index = ($producto['id'] + intval($seed)) % count($descuentos_disponibles);
      $descuento = $descuentos_disponibles[$descuento_index];

      $precio_final = $producto['precio'] * (1 - $descuento / 100);
  ?>
    <div class="card">
      <a href="producto.php?id=<?= $producto['id'] ?>&promo=1&desc=<?= $descuento ?>">
        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="Imagen del producto">
      </a>
      <div class="card-body">
        <span class="etiqueta-promo">-<?= $descuento ?>% OFF</span>
        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
        <p class="precio-anterior">$<?= number_format($producto['precio'], 2, ',', '.') ?></p>
        <p class="precio-descuento">$<?= number_format($precio_final, 2, ',', '.') ?></p>
      </div>
    </div>
  <?php } ?>
  </div>
</div>


</body>