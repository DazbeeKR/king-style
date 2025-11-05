<?php
session_start();

// Si no hay usuario logueado, redirigir a login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del usuario desde la base
$id = $_SESSION['id_usuario'];
$sql = "SELECT email_usuario FROM usuarios WHERE id_usuario = '$id'";
$result = $conn->query($sql);

$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Usuario</title>
</head>
<body>
  <h1>Perfil de Usuario</h1>
  <p><strong>ID:</strong> <?php echo $id; ?></p>
  <p><strong>Email:</strong> <?php echo $usuario['email_usuario']; ?></p>

  <a href="logout.php">Cerrar sesión</a>
</body>
</html>
