<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$busqueda = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : "";
$precio_min = isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : 0;
$orden = isset($_GET['orden']) ? $conn->real_escape_string($_GET['orden']) : "";


$sql = "SELECT * FROM productos WHERE (nombre LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%')";


if ($precio_min > 0) {
    $sql .= " AND precio >= $precio_min";
}
if ($precio_max > 0) {
    $sql .= " AND precio <= $precio_max";
}


if ($orden == "menor_mayor") {
    $sql .= " ORDER BY precio ASC";
} elseif ($orden == "mayor_menor") {
    $sql .= " ORDER BY precio DESC";
}

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resultados de búsqueda</title>
<link rel="stylesheet" href="style.css">
<style>

.container-busqueda {
  display: flex;
  gap: 20px;
  margin: 20px;
}

/* === SIDEBAR === */
.sidebar-filtros {
  width: 240px;
  background: #f8f8f8;
  padding: 20px;
  border-radius: 10px;
  height: fit-content;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.sidebar-filtros h3 {
  margin-bottom: 10px;
  font-size: 18px;
}

.sidebar-filtros form label {
  display: block;
  margin-top: 10px;
  font-weight: 500;
}

.sidebar-filtros input[type="number"],
.sidebar-filtros select {
  width: 100%;
  padding: 6px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.sidebar-filtros button {
  margin-top: 15px;
  width: 100%;
  background-color: black;
  color: white;
  padding: 8px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.sidebar-filtros button:hover {
  background-color: #444;
}

.productos-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  flex: 1;
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

.productos-row .card .card-img-top {
  width: 100%;
  height: auto;
  max-height: 250px;
  object-fit: cover;
  border-radius: 6px 6px 0 0;
  transition: transform 0.3s ease;
}

.productos-row .card .card-img-top:hover {
  transform: scale(1.05);
}

@media (max-width: 992px) {
  .productos-row .card {
    flex: 1 1 calc(50% - 20px);
  }
}

@media (max-width: 768px) {
  .container-busqueda {
    flex-direction: column;
  }
  .sidebar-filtros {
    width: 100%;
  }
  .productos-row .card {
    flex: 1 1 100%;
  }
}
</style>
</head>

<body>
<?php include 'navegacion/barra_navegacion.php'; ?>

<h2 style="margin:20px;">Resultados de: "<?= htmlspecialchars($busqueda) ?>"</h2>

<div class="container-busqueda">

  <aside class="sidebar-filtros">
    <h3>Filtros</h3>
    <form method="GET" action="buscar.php">
      <input type="hidden" name="q" value="<?= htmlspecialchars($busqueda) ?>">

      <label for="precio_min">Precio mínimo:</label>
      <input type="number" name="precio_min" id="precio_min" value="<?= htmlspecialchars($precio_min) ?>" min="0">

      <label for="precio_max">Precio máximo:</label>
      <input type="number" name="precio_max" id="precio_max" value="<?= htmlspecialchars($precio_max) ?>" min="0">

      <label for="orden">Ordenar por:</label>
      <select name="orden" id="orden">
        <option value="">Sin orden</option>
        <option value="menor_mayor" <?= $orden=="menor_mayor"?"selected":"" ?>>Precio: menor a mayor</option>
        <option value="mayor_menor" <?= $orden=="mayor_menor"?"selected":"" ?>>Precio: mayor a menor</option>
      </select>

      <button type="submit">Aplicar filtros</button>
    </form>
  </aside>


  <div class="productos-row">
    <?php if ($resultado->num_rows > 0): ?>
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
  </div>
</div>

</body>
</html>