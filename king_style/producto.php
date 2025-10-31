<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir y validar el ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<p>❌ Producto no encontrado.</p>";
    exit;
}

// Consultar producto por ID
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #fff;
        }

        .producto-detalle {
            display: flex;
            flex-wrap: wrap;
            max-width: 1100px;
            margin: 40px auto;
            gap: 40px;
            padding: 20px;
        }

        .producto-detalle img {
            flex: 1 1 400px;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            object-fit: cover;
        }

        .info {
            flex: 1 1 400px;
        }

        .info h1 {
            font-size: 2em;
            margin-bottom: 15px;
        }

        .info p {
            margin: 10px 0;
            color: #333;
            line-height: 1.5;
        }

        .precio {
            font-size: 1.8em;
            font-weight: bold;
            color: #008080;
            margin: 15px 0;
        }

        .talle {
            margin: 15px 0;
        }

        select {
            padding: 8px;
            font-size: 1em;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .btn-agregar {
            background-color: #008080;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-agregar:hover {
            background-color: #006666;
        }

        a.volver {
            display: inline-block;
            margin: 30px auto;
            text-decoration: none;
            color: #008080;
            font-weight: bold;
        }

        a.volver:hover {
            text-decoration: underline;
        }

        .precio-anterior {
        text-decoration: line-through;
        color: #999;
        }
        
        .etiqueta-promo {
        background: #008080;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 10px;
        }
    </style>
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
    // 🔹 Detectar si viene desde la promo
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
        <!-- 🔹 Selección de talle -->
        <form action="agregar_carrito.php<?= (isset($_GET['promo']) && isset($_GET['desc'])) ? '?promo=1&desc=' . intval($_GET['desc']) : '' ?>" method="POST">
            <div class="talle">
                <label for="talle"><strong>Seleccionar talle:</strong></label><br>
                <select name="talle" id="talle" required>
                    <option value="">-- Elegí un talle --</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>

            <!-- Datos ocultos -->
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
            <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
            <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
            <input type="hidden" name="imagen" value="<?= $producto['imagen'] ?>">

            <button type="submit" class="btn-agregar">Agregar al carrito 🛒</button>
        </form>

        <a href="index.php" class="volver">⬅ Volver a la tienda</a>
    </div>
</div>

<?php include 'navegacion/footer.html'; ?>

</body>
</html>
