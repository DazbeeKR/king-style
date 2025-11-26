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

$email = $_POST['email_usuario'] ?? '';
$pass = $_POST['contrasena_usuario'] ?? '';

if (empty($email) || empty($pass)) {
    header("Location: login.php?error=campos_vacios");
    exit();
}

$sql = "SELECT id_usuario, email_usuario, contrasena_usuario FROM usuarios WHERE email_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: login.php?error=usuario_no_existe");
    exit();
}

$user = $result->fetch_assoc();

if (!password_verify($pass, $user['contrasena_usuario'])) {
    header("Location: login.php?error=pass_incorrecta");
    exit();
}

$_SESSION['id_usuario'] = $user['id_usuario'];
$_SESSION['email_usuario'] = $user['email_usuario'];

header("Location: index.php");
exit();
?>
