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
$usuario = $sql->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - King Style</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdf6e3, #ffffff);
            margin: 0;
            color: #222;
        }

        .perfil-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 40px;
            background: #111;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        h2 {
            font-size: 32px;
            font-weight: 700;
            color: #ffcc00;
            margin-bottom: 30px;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: 600;
            margin-top: 15px;
            align-self: flex-start;
            color: #ffcc00;
        }

        input[type="text"], 
        input[type="email"], 
        input[type="password"], 
        input[type="file"] {
            width: 90%;
            padding: 12px 15px;
            margin-top: 5px;
            border-radius: 15px;
            border: none;
            background: #1a1a1a;
            color: #fff;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);
        }

        input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        hr {
            width: 90%;
            border: 1px solid #ffcc00;
            margin: 25px 0;
        }

        h3 {
            color: #ffcc00;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .foto-preview {
            display: block;
            margin: 15px auto;
            border-radius: 50%;
            width: 140px;
            height: 140px;
            object-fit: cover;
            border: 3px solid #ffcc00;
        }

        .btn-guardar {
            display: inline-block;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: #000;
            border: 2px solid #ffcc00;
            border-radius: 40px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            margin: 20px 0;
            cursor: pointer;
        }

        .btn-guardar:hover {
            background: #ffcc00;
            color: #000;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
        }

        @media (max-width: 500px) {
            input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="perfil-container">
    <h2>Editar Perfil</h2>

    <form action="guardar_perfil.php" method="POST" enctype="multipart/form-data">

        <label>Email:</label>
        <input type="email" name="email" value="<?= $usuario['email_usuario']; ?>">

        <label>Cambiar contraseña:</label>
        <input type="password" name="contrasena" placeholder="Opcional">

        <label>Foto de perfil:</label>
        <?php if (!empty($usuario['imagen'])): ?>
            <img src="<?= $usuario['imagen']; ?>" class="foto-preview">
        <?php else: ?>
            <img src="imgProductos/user-icon.jpg" class="foto-preview">
        <?php endif; ?>
        <input type="file" name="imagen" accept="image/*">

        <hr>
        <h3>Dirección Principal</h3>

        <label>Nombre completo:</label>
        <input type="text" name="nombre_completo" value="<?= $usuario['nombre_completo']; ?>">

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?= $usuario['direccion']; ?>">

        <label>Ciudad:</label>
        <input type="text" name="ciudad" value="<?= $usuario['ciudad']; ?>">

        <label>Provincia:</label>
        <input type="text" name="provincia" value="<?= $usuario['provincia']; ?>">

        <label>Código Postal:</label>
        <input type="text" name="codigo_postal" value="<?= $usuario['codigo_postal']; ?>">

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= $usuario['telefono']; ?>">

        <button class="btn-guardar" type="submit">Guardar Cambios</button>

    </form>
</div>
</body>
</html>
