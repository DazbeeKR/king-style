<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);
?>

<head>
  <style>
.productos-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.productos-row .card {
  flex: 1 1 calc(25% - 20px);
  min-width: 220px;
  max-width: 320px;
  border: none;
  box-shadow: 0 6px 10px rgba(0,0,0,0.05);
  transition: transform 0.2s ease-in-out;
}

.productos-row .card:hover { transform: scale(1.04); }

.productos-row .card .card-img-top {
  width: 100%;
  height: auto;
  max-height: 250px;
  object-fit: cover;
  border-radius: 6px 6px 0 0;
}

.precio-anterior {
  text-decoration: line-through;
  color: #999;
  font-size: 0.9em;
}

.precio-descuento {
  color: #008080;
  font-weight: bold;
  font-size: 1.1em;
}

.etiqueta-promo {
  background: #008080;
  color: white;
  padding: 5px 10px;
  font-size: 0.9em;
  border-radius: 6px;
  display: inline-block;
  margin-bottom: 10px;
}

h2.seccion {
  text-align: center;
  margin: 40px 0 20px;
  color: #333;
}


@media (max-width: 992px) {
  .productos-row .card { flex: 1 1 calc(50% - 20px); }
}
@media (max-width: 576px) {
  .productos-row .card { flex: 1 1 100%; }
}
  </style>
</head>

<body>

<?php
session_start();
if (isset($_SESSION['mensaje'])) {
    echo "<p style='color:green;'>" . $_SESSION['mensaje'] . "</p>";
    unset($_SESSION['mensaje']);
}
?>

<h2 class="seccion">🆕 Últimos productos</h2>
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


<h2 class="seccion">🔥 Promociones exclusivas</h2>
<div class="container mt-4">
  <div class="productos-row">
  <?php

  $seed = date('Ymd'); // Ej: 20251105
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