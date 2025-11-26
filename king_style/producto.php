<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<p>❌ Producto no encontrado.</p>";
    exit;
}

$sql = "SELECT * FROM productos WHERE id = $id";
$resultado = $conn->query($sql);

if ($resultado->num_rows == 0) {
    echo "<p>❌ Producto no encontrado.</p>";
    exit;
}

$producto = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($producto['nombre']) ?> - Detalle del producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navegacion/barra_navegacion.php'; ?>

<div class="producto-detalle">
    <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">

    <div class="info">
        <h1><?= htmlspecialchars($producto['nombre']) ?></h1>

        <?php if (!empty($producto['descripcion'])): ?>
            <p><?= htmlspecialchars($producto['descripcion']) ?></p>
        <?php else: ?>
            <p>Sin descripción disponible.</p>
        <?php endif; ?>

        <?php
        if (isset($_GET['promo']) && isset($_GET['desc'])) {
            $descuento = intval($_GET['desc']);
            $precio_final = $producto['precio'] * (1 - $descuento / 100);
            echo "<p class='etiqueta-promo'>🔥 ¡Este producto está en promoción!</p>";
            echo "<p class='precio-anterior'>$" . number_format($producto['precio'], 2, ',', '.') . "</p>";
            echo "<p class='precio'>Ahora: $" . number_format($precio_final, 2, ',', '.') . " (-$descuento%)</p>";
        } else {
            echo "<p class='precio'>$" . number_format($producto['precio'], 2, ',', '.') . "</p>";
        }
        ?>

        <?php if (isset($producto['stock'])): ?>
            <?php if ($producto['stock'] > 0): ?>
                <div class="stock-disponible stock-alto">✅ Stock disponible: <?= $producto['stock'] ?> unidades</div>
            <?php else: ?>
                <div class="stock-disponible stock-bajo">❌ Sin stock disponible</div>
            <?php endif; ?>
        <?php endif; ?>


        <form action="agregar_carrito.php<?= (isset($_GET['promo']) && isset($_GET['desc'])) ? '?promo=1&desc=' . intval($_GET['desc']) : '' ?>" method="POST">
            <div class="talle">
                <label for="talle"><strong>Seleccionar talle:</strong></label><br>
                <select name="talle" id="talle" required>
                    <option value="">-- Elegí un talle --</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="XXXL">XXXL</option>
                </select>
            </div>

            <div class="cantidad">
                <label for="cantidad"><strong>Cantidad:</strong></label><br>
                <select name="cantidad" id="cantidad" required>
                    <?php
                    $max_stock = isset($producto['stock']) && $producto['stock'] > 0 ? $producto['stock'] : 0;
                    if ($max_stock > 0) {
                        for ($i = 1; $i <= $max_stock; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                    } else {
                        echo "<option disabled>Sin stock</option>";
                    }
                    ?>
                </select>
            </div>

            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
            <input type="hidden" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>">
            <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
            <input type="hidden" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>">

            <button class="boton-carrito" type="submit" class="btn-agregar" <?= ($producto['stock'] <= 0 ? 'disabled' : '') ?>>Agregar al carrito</button>
        </form>
        

        <a href="index.php" class="volver">⬅ Volver a la tienda</a>
    </div>
</div>

<?php include 'navegacion/footer.html'; ?>

</body>
</html>
