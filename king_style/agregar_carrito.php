<?php
session_start();

// Si no existe el carrito, lo creamos
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Verificamos que haya datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {

    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'] ?? 'Producto sin nombre';
    $precio = floatval($_POST['precio']);
    $imagen = $_POST['imagen'] ?? '';
    $talle = $_POST['talle'] ?? "Sin talle";
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1; // ✅ Nueva línea

    // Si hay descuento desde la URL (por promo)
    $descuento = (isset($_GET['promo']) && isset($_GET['desc'])) ? intval($_GET['desc']) : 0;

    // Revisar si ya está en el carrito (mismo producto y mismo talle)
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id && $item['talle'] == $talle) {
            // ✅ Ahora suma la cantidad seleccionada, no solo +1
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }

    // Si no estaba, lo agregamos con la cantidad elegida
    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'imagen' => $imagen,
            'talle' => $talle,
            'cantidad' => $cantidad, // ✅ Guardamos cantidad seleccionada
            'descuento' => $descuento
        ];
    }

    // Mensaje de éxito
    $_SESSION['mensaje'] = "Producto ($nombre - Talle $talle x$cantidad) agregado al carrito ✅";

    // 🔹 Redirigir SIEMPRE al carrito (evita bucles)
    header("Location: carrito.php");
    exit;
}

// Si llega sin datos válidos, volver al inicio
header("Location: index.php");
exit;
?>
