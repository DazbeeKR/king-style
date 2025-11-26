<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id_usuario'];

$email = trim($_POST['email']);
$contrasena = trim($_POST['contrasena']);

$nombre = trim($_POST['nombre_completo']);
$direccion = trim($_POST['direccion']);
$ciudad = trim($_POST['ciudad']);
$provincia = trim($_POST['provincia']);
$postal = trim($_POST['codigo_postal']);
$telefono = trim($_POST['telefono']);

$errores = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email no tiene un formato válido.";
}

$sql = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ? AND id_usuario != ?");
$sql->bind_param("si", $email, $id);
$sql->execute();
$res = $sql->get_result();

if ($res->num_rows > 0) {
    $errores[] = "Este email ya está en uso por otro usuario.";
}

if ($contrasena !== "" && strlen($contrasena) < 6) {
    $errores[] = "La contraseña debe tener al menos 6 caracteres.";
}

$imagen_ruta = null;
if (!empty($_FILES['imagen']['name'])) {

    $permitidos = ['image/jpeg', 'image/png'];
    $tipo = $_FILES['imagen']['type'];
    $size = $_FILES['imagen']['size'];

    if (!in_array($tipo, $permitidos)) {
        $errores[] = "La imagen debe ser JPG o PNG.";
    }

    if ($size > 3 * 1024 * 1024) {
        $errores[] = "La imagen no puede superar los 3MB.";
    }
}

if (!empty($errores)) {
    $errores_txt = urlencode(implode("<br>", $errores));
    header("Location: editar_perfil.php?error=$errores_txt");
    exit;
}

if (!empty($_FILES['imagen']['name'])) {
    $nombre_archivo = time() . "_" . $_FILES['imagen']['name'];
    $destino = "uploads/" . $nombre_archivo;

    move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
    $imagen_ruta = $destino;
}

$query = "UPDATE usuarios SET email_usuario=?, nombre_completo=?, direccion=?, ciudad=?, provincia=?, codigo_postal=?, telefono=?";
$params = [$email, $nombre, $direccion, $ciudad, $provincia, $postal, $telefono];
$types = "sssssss";

if ($imagen_ruta) {
    $query .= ", imagen=?";
    $params[] = $imagen_ruta;
    $types .= "s";
}

if ($contrasena !== "") {
    $query .= ", contrasena_usuario=?";
    $params[] = $contrasena;
    $types .= "s";
}

$query .= " WHERE id_usuario=?";
$params[] = $id;
$types .= "i";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();

header("Location: perfil.php?ok=1");
exit;
