<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - King Style</title>

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

        .register-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-container input {
            width: 90%;
            padding: 12px 15px;
            margin: 0 auto 12px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.2s;
            display: block;
        }

        .input-error {
            border-color: #e74c3c !important;
            box-shadow: 0 0 6px rgba(231, 76, 60, 0.4);
        }

        .error-text {
            color: #e74c3c;
            font-size: 14px;
            margin-top: -8px;
            margin-bottom: 10px;
            text-align: left;
        }

        .register-container button {
            width: 100%;
            padding: 12px;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: .2s;
        }

        .register-container button:disabled {
            background: #777;
            cursor: not-allowed;
        }

        .register-container button:hover:not(:disabled) {
            background: #333;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="register-container">
    <img src="imgProductos/king_style_logo.png" alt="Logo" class="logo">

    <h2>Crear cuenta</h2>

    <form action="registrar_usuario.php" method="POST">

        <input type="email" name="email_usuario"  id="email"placeholder="Correo electrónico"value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>"class="<?php echo (isset($_GET['error']) && $_GET['error'] == 'campos_vacios') ? 'input-error' : ''; ?>"required>

        <?php if (isset($_GET['error']) && $_GET['error'] == "campos_vacios"): ?>
            <div class="error-text">Por favor, completa todos los campos.</div>
        <?php endif; ?>

        <input type="password" name="contrasena_usuario" id="pass" placeholder="Contraseña" required>

        <div id="error-length" class="error-text" style="display:none;">Debe ingresar al menos 8 caracteres.</div>
        <div id="error-number" class="error-text" style="display:none;">Necesita ingresar al menos un número.</div>
        <div id="error-space" class="error-text" style="display:none;">La contraseña no puede contener espacios.</div>

        <input type="password" name="verificar_contraseña" id="pass2" placeholder="Verificar contraseña" required>
        <div id="pass-error-js" class="error-text" style="display:none;">Las contraseñas no coinciden.</div>

        <?php if (isset($_GET['error']) && $_GET['error'] == "pass_no_coinciden"): ?>
            <div class="error-text">Las contraseñas no coinciden.</div>
        <?php endif; ?>

        <button type="submit" id="submitBtn">Registrarme</button>

    </form>
</div>

</body>
</html>
