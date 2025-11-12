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

$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (email_usuario, contraseña_usuario) VALUES ('$email', '$pass_hash')";

if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id;

    $_SESSION['id_usuario'] = $user_id;
    $_SESSION['email_usuario'] = $email;

    header("Location: index.html");
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
