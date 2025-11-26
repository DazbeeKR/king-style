<?php
session_start();


if (isset($_GET['accion']) && isset($_GET['id']) && isset($_GET['talle'])) {
    $accion = $_GET['accion'];
    $id = intval($_GET['id']);
    $talle = $_GET['talle'];

    foreach ($_SESSION['carrito'] as $index => $item) {
        if ($item['id'] == $id && $item['talle'] == $talle) {

            if ($accion === 'eliminar') {
                unset($_SESSION['carrito'][$index]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                $mensaje = "🗑️ Producto eliminado del carrito.";
                break;
            }

            if ($accion === 'editar') {
                $producto_id = $item['id'];
                unset($_SESSION['carrito'][$index]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                header("Location: producto.php?id=" . $producto_id);
                exit;
            }
        }
    }
}


if (isset($_POST['finalizar'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "halo";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
            $id_producto = intval($item['id']);
            $cantidad = intval($item['cantidad']);

            $sql = "UPDATE productos SET stock = GREATEST(stock - $cantidad, 0) WHERE id = $id_producto";
            $conn->query($sql);
        }
    }

    $conn->close();

    unset($_SESSION['carrito']);
    $mensaje = "¡Compra finalizada con éxito!";
}


$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="style.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .contenedor {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .productos {
            flex: 2;
            min-width: 300px;
        }

        .producto {
            display: flex;
            gap: 15px;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
            align-items: center;
        }

        .producto img {
            width: 100px;
            height: auto;
            border: 1px solid #ddd;
        }

        .producto-info {
            flex: 1;
        }

        .producto-nombre {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .producto-precio {
            font-weight: bold;
            font-size: 14px;
            margin-top: 8px;
        }

        .acciones {
            margin-top: 8px;
            font-size: 13px;
        }

        .acciones a {
            margin-right: 10px;
            color: #333;
            text-decoration: none;
        }

        .acciones a:hover {
            text-decoration: underline;
        }

        .resumen {
            flex: 1;
            border: 1px solid #000;
            padding: 20px;
            min-width: 250px;
        }

        .resumen h3 {
            margin-top: 0;
        }

        .resumen p {
            margin: 8px 0;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            background: #000;
            color: #fff;
            border: none;
            font-size: 15px;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #444;
        }

        .detalle {
            font-size: 12px;
            color: #555;
        }

        footer {
            background-color: #222;
            color: #fff;
            padding: 30px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
        }

        @media (max-width: 768px) {
            .contenedor {
                flex-direction: column;
            }

            .resumen {
                width: 100%;
            }
        }
    </style>
</head>

<body>


    <?php include 'navegacion/barra_navegacion.php'; ?>

    <main>
        <h2>Carrito de Compras</h2>

        <?php if (isset($mensaje)): ?>
            <p style="color:green;"><?= $mensaje ?></p>
        <?php endif; ?>

        <div class="contenedor">

            <div class="productos">
                <h3>ARTÍCULO</h3>
                <?php if (!empty($_SESSION['carrito'])): ?>
                    <?php foreach ($_SESSION['carrito'] as $item): ?>
                    <div class="producto">
                        <img src="<?= $item['imagen'] ?>" alt="<?= $item['nombre'] ?>">
                        <div class="producto-info">
                        <div class="producto-nombre"><?= htmlspecialchars($item['nombre']) ?></div>
                        <div><strong>Talle:</strong> <?= htmlspecialchars($item['talle']) ?></div>
                        <div><strong>Cantidad:</strong> <?= $item['cantidad'] ?></div>

                        <?php if (!empty($item['descuento']) && $item['descuento'] > 0): ?>
                            <p class="detalle">Descuento aplicado: <?= $item['descuento'] ?>%</p>
                        <?php endif; ?>

                        <p class="producto-precio">
                            ARS <?= number_format($item['precio'], 2, ',', '.') ?>
                        </p>
                            <div class="acciones">
                                <a href="carrito.php?accion=eliminar&id=<?= $item['id'] ?>&talle=<?= urlencode($item['talle']) ?>">eliminar</a>
                                <a href="carrito.php?accion=editar&id=<?= $item['id'] ?>&talle=<?= urlencode($item['talle']) ?>">editar</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Tu carrito está vacío.</p>
                <?php endif; ?>
            </div>

            <div class="resumen">
                <h3>RESUMEN DEL PEDIDO</h3>
                <?php if (!empty($_SESSION['carrito'])): ?>
                    <p><strong>Total estimado:</strong> 
                        ARS <?= number_format($total, 2, ',', '.') ?></p>
                        <a href="#">detalles</a></p>
                    <p class="detalle">*Los artículos se cobrarán cuando se envíen. 
                    El importe real se cobrará de acuerdo al tipo de cambio al momento del envío.</p>

                    <form method="POST">
                        <button class="btn" name="finalizar">Finalizar compra</button>
                    </form>
                <?php else: ?>
                    <p>No hay productos.</p>
                <?php endif; ?>
            </div>
        </div>

        <br>
        <a href="index.php">⬅ Seguir comprando</a>
    </main>

    <?php include 'navegacion/footer.html'; ?>

</body>
</html>
