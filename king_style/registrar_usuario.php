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
$pass = $_POST['contrasena_usuario'];
$pass2 = $_POST['verificar_contraseña'];

if (empty($email) || empty($pass) || empty($pass2)) {
    header("Location: registrar.php?error=campos_vacios&email=$email");
    exit();
}

if ($pass !== $pass2) {
    header("Location: registrar.php?error=pass_no_coinciden&email=$email");
    exit();
}

$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (email_usuario, contrasena_usuario) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $pass_hash);

if ($stmt->execute()) {

    $user_id = $stmt->insert_id;
    $_SESSION['id_usuario'] = $user_id;
    $_SESSION['email_usuario'] = $email;

    header("Location: index.php");
    exit();

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
