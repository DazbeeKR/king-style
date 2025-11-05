<?php
session_start(); // 👈 habilitamos sesiones

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$email = $_POST['email_usuario'];
$pass = $_POST['contraseña_usuario'];

// Encriptar contraseña
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (email_usuario, contraseña_usuario) VALUES ('$email', '$pass_hash')";

if ($conn->query($sql) === TRUE) {
    // Obtener el ID del nuevo usuario
    $user_id = $conn->insert_id;

    // Guardar sesión
    $_SESSION['id_usuario'] = $user_id;
    $_SESSION['email_usuario'] = $email;

    // Redirigir al index
    header("Location: index.html");
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
