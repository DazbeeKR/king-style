<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id_usuario'];

$sql = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$sql->bind_param("i", $id);
$sql->execute();
$u = $sql->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - King Style</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="perfil-container">
    <h2 class="perfil-titulo">Mi Perfil</h2>

    <img src="<?= $u['imagen'] ?: 'imgProductos/user-icon.jpg' ?>" class="perfil-foto">

    <div class="perfil-info">
        <div><strong>Email:</strong> <span><?= $u['email_usuario'] ?></span></div>
        <div><strong>Nombre:</strong> <span><?= $u['nombre_completo'] ?: 'No especificado' ?></span></div>
        <div><strong>Teléfono:</strong> <span><?= $u['telefono'] ?: 'No especificado' ?></span></div>
    </div>

    <div class="perfil-direccion">
        <h3>Dirección Principal</h3>
        <div><strong>Dirección:</strong> <span><?= $u['direccion'] ?: '—' ?></span></div>
        <div><strong>Ciudad:</strong> <span><?= $u['ciudad'] ?: '—' ?></span></div>
        <div><strong>Provincia:</strong> <span><?= $u['provincia'] ?: '—' ?></span></div>
        <div><strong>Código Postal:</strong> <span><?= $u['codigo_postal'] ?: '—' ?></span></div>
    </div>

    <a href="editar_perfil.php" class="btn-king-style">Editar Perfil</a>

    <div class="perfil-botones">
        <a href="index.php" class="btn-king-style">Volver al Inicio</a>
    </div>
</div>

</body>
</html>
