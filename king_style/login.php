<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - King Style</title>

    <style>
        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container input {
            width: 90%;
            padding: 12px;
            margin: 0 auto 12px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .error-text {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #333;
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="login-container">
    <img src="imgProductos/king_style_logo.png" class="logo" alt="Logo">

    <h2>Iniciar sesión</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error-text">
            <?php
                switch($_GET['error']) {
                    case 'campos_vacios': echo "Completa todos los campos."; break;
                    case 'usuario_no_existe': echo "El usuario no existe."; break;
                    case 'pass_incorrecta': echo "La contraseña es incorrecta."; break;
                }
            ?>
        </div>
    <?php endif; ?>

    <form action="iniciar_sesion.php" method="POST">
        <input type="email" name="email_usuario" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena_usuario" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    <p style="margin-top:15px;">
        ¿No tenés cuenta? <a href="registrar.php">Registrate aquí</a>
    </p>
</div>

</body>
</html>
