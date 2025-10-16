<?php
session_start();

// Finalizar compra → vaciar carrito
if (isset($_POST['finalizar'])) {
    unset($_SESSION['carrito']);
    $mensaje = "✅ ¡Compra finalizada con éxito!";
}

// Calcular total si hay productos
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
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .contenedor {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        .productos {
            flex: 2;
        }
        .resumen {
            flex: 1;
            border: 1px solid #000;
            padding: 20px;
        }
        .producto {
            display: flex;
            gap: 15px;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
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
        }
        .btn:hover {
            background: #444;
        }
        .detalle {
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <?php include 'navegacion/barra_navegacion.html' ?>

    <h2>Carrito de Compras</h2>

    <?php if (isset($mensaje)): ?>
        <p style="color:green;"><?= $mensaje ?></p>
    <?php endif; ?>

    <div class="contenedor">
        <!-- Lista de productos -->
        <div class="productos">
            <h3>ARTÍCULO</h3>
            <?php if (!empty($_SESSION['carrito'])): ?>
                <?php foreach ($_SESSION['carrito'] as $item): ?>
                <div class="producto">
                    <img src="<?= $item['imagen'] ?>" alt="<?= $item['nombre'] ?>">
                    <div class="producto-info">
                        <div class="producto-nombre"><?= $item['nombre'] ?></div>
                        <div>Cantidad: <?= $item['cantidad'] ?></div>
                        <p class="producto-precio">
                            ARS <?= number_format($item['precio'], 2, ',', '.') ?>
                        </p>
                        <div class="acciones">
                            <a href="#">guardar para después</a>
                            <a href="#">mover a favoritos</a>
                            <a href="#">eliminar</a>
                            <a href="#">editar</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tu carrito está vacío.</p>
            <?php endif; ?>
        </div>

        <!-- Resumen del pedido -->
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
                <button class="btn">Iniciar sesión para pagar más rápido</button>
            <?php else: ?>
                <p>No hay productos.</p>
            <?php endif; ?>
        </div>
    </div>

    <br>
    <a href="index.html">⬅ Seguir comprando</a>

    <?php include 'navegacion/footer.html' ?>
</body>
</html>

