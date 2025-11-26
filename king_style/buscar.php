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
$stock = isset($_GET['stock']) ? (int)$_GET['stock'] : 0;

$sql = "SELECT * FROM productos WHERE (nombre LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%')";
if ($precio_min > 0) $sql .= " AND precio >= $precio_min";
if ($precio_max > 0) $sql .= " AND precio <= $precio_max";
if ($stock > 0) $sql .= " AND stock >= $stock";

if ($orden == "menor_mayor") $sql .= " ORDER BY precio ASC";
elseif ($orden == "mayor_menor") $sql .= " ORDER BY precio DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resultados de búsqueda - King Style</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navegacion/barra_navegacion.php'; ?>

<h2>Resultados de: "<?= htmlspecialchars($busqueda) ?>"</h2>

<div class="container-busqueda">

  <aside class="sidebar-filtros">
      <div class="filtro-campo">
        <label for="precio_min">Precio mínimo:</label>
        <input type="number" name="precio_min" id="precio_min" value="<?= htmlspecialchars($precio_min) ?>" min="0">
      </div>

      <div class="filtro-campo">
        <label for="precio_max">Precio máximo:</label>
        <input type="number" name="precio_max" id="precio_max" value="<?= htmlspecialchars($precio_max) ?>" min="0">
      </div>

      <div class="filtro-campo">
        <label for="orden">Ordenar por:</label>
        <select name="orden" id="orden">
          <option value="">Sin orden</option>
          <option value="menor_mayor" <?= $orden=="menor_mayor"?"selected":"" ?>>Precio: menor a mayor</option>
          <option value="mayor_menor" <?= $orden=="mayor_menor"?"selected":"" ?>>Precio: mayor a menor</option>
        </select>
      </div>

      <div class="filtro-campo">
        <label for="stock">Stock mínimo:</label>
        <input type="number" name="stock" id="stock" value="<?= $stock ?>" min="0">
      </div>

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
            </form>
          </div>
        </div>
      <?php } ?>
    <?php else: ?>
      <p style="text-align:center; color:#ffcc00;">No se encontraron productos con esa búsqueda.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
