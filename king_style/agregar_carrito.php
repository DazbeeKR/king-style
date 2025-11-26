<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {

    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'] ?? 'Producto sin nombre';
    $precio = floatval($_POST['precio']);
    $imagen = $_POST['imagen'] ?? '';
    $talle = $_POST['talle'] ?? "Sin talle";
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    $descuento = (isset($_GET['promo']) && isset($_GET['desc'])) ? intval($_GET['desc']) : 0;

    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id && $item['talle'] == $talle) {
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'imagen' => $imagen,
            'talle' => $talle,
            'cantidad' => $cantidad,
            'descuento' => $descuento
        ];
    }

    $_SESSION['mensaje'] = "Producto ($nombre - Talle $talle x$cantidad) agregado al carrito ✅";

    header("Location: carrito.php");
    exit;
}

header("Location: index.php");
exit;
?>