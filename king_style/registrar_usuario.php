<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$email = $_POST['email_usuario'];
$pass = $_POST['contraseña_usuario'];
$pass2 = $_POST['verificar_contraseña'];

// Validar campos vacíos
if (empty($email) || empty($pass) || empty($pass2)) {
    header("Location: registro.php?error=campos_vacios");
    exit();
}

// Verificar coincidencia de contraseñas
if ($pass !== $pass2) {
    header("Location: registro.php?error=pass_no_coinciden");
    exit();
}

// Hash contraseña
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// Insertar en la BD
$sql = "INSERT INTO usuarios (email_usuario, contraseña_usuario) VALUES ('$email', '$pass_hash')";

if ($conn->query($sql) === TRUE) {

    $user_id = $conn->insert_id;
    $_SESSION['id_usuario'] = $user_id;
    $_SESSION['email_usuario'] = $email;

    // Envío de email
    $to = $email;
    $subject = "Registro exitoso - King Style";
    $message = "¡Bienvenido a King Style!\nTu cuenta ha sido creada exitosamente.";
    $headers = "From: noreply@kingstyle.com";

    @mail($to, $subject, $message, $headers);

    header("Location: index.html");
    exit();

} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
