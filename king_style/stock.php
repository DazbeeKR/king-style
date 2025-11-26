<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "halo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$busqueda = "";
if (isset($_GET['q'])) {
    $busqueda = $conn->real_escape_string($_GET['q']);
    $sql = "SELECT * FROM productos 
            WHERE nombre LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%'
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM productos ORDER BY id DESC";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Productos - King Style</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<img src="imgProductos/king_style_logo.png" class="logo-central" alt="Logo King Style">

<h2>Gestión de Productos</h2>
<a href="agregar_producto.php" class="btn-agregar-producto">Agregar Producto</a>
<form class="buscador" method="GET">
    <input type="text" name="q" placeholder="Buscar por nombre o categoría..." value="<?= htmlspecialchars($busqueda) ?>">
    <button type="submit">Buscar</button>
    <?php if (!empty($busqueda)): ?>
        <a href="stock.php" style="margin-left:10px; color:#000; font-weight:600; text-decoration:none;">✖ Limpiar</a>
    <?php endif; ?>
</form>

<?php if ($result && $result->num_rows > 0): ?>
<table>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): 
        $claseStock = ($row['stock'] <= 5) ? 'stock-bajo' :
                      (($row['stock'] <= 15) ? 'stock-medio' : 'stock-alto');
    ?>
    <tr id="fila-<?= $row['id'] ?>">
        <td><img src="<?= htmlspecialchars($row['imagen']) ?>" alt="Producto"></td>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= htmlspecialchars($row['categoria']) ?></td>
        <td>$<?= number_format($row['precio'], 2) ?></td>
        <td><span class="<?= $claseStock ?>"><?= $row['stock'] ?></span></td>
        <td>
            <button class="editar" onclick='abrirModal(<?= json_encode($row) ?>)'>Editar</button>
            <button class="eliminar" onclick="eliminarProducto(<?= $row['id'] ?>)">Eliminar</button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p style="text-align:center;">No hay productos cargados o no hay coincidencias con tu búsqueda.</p>
<?php endif; ?>

<div id="modal" class="modal">
    <div class="modal-contenido">
        <h3>Editar producto</h3>
        <form id="formEditar" enctype="multipart/form-data">
            <input type="hidden" name="id" id="editId">
            <img id="editImagenPreview" src="" alt="Imagen del producto">

            <label>Imagen nueva:</label>
            <input type="file" name="imagen" id="editImagen">

            <label>Nombre:</label>
            <input type="text" name="nombre" id="editNombre" required>

            <label>Categoría:</label>
            <input type="text" name="categoria" id="editCategoria" required>

            <label>Descripción:</label>
            <textarea name="descripcion" id="editDescripcion"></textarea>

            <label>Precio:</label>
            <input type="number" name="precio" id="editPrecio" step="0.01" required>

            <label>Stock:</label>
            <input type="number" name="stock" id="editStock" required>

            <button type="button" onclick="guardarCambios()">Guardar Cambios</button>
            <p id="mensajeModal" class="mensaje"></p>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
