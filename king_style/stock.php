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
<title>Gestión de Productos</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f9fafb;
    padding: 20px;
}
h2 { color: #222; margin-bottom: 20px; }
.buscador { margin-bottom: 20px; }
.buscador input[type="text"] {
    padding: 8px 12px; width: 250px; border-radius: 8px; border: 1px solid #ccc;
}
.buscador button {
    padding: 8px 12px; border: none; border-radius: 8px;
    background-color: #007bff; color: white; cursor: pointer;
}
.buscador button:hover { background-color: #0056b3; }
table {
    border-collapse: collapse; width: 100%; background-color: white;
    border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: center; }
th { background-color: #f2f4f7; color: #333; }
img { max-width: 80px; border-radius: 8px; }
.stock-bajo { background-color: #dc3545; color: white; padding: 6px 10px; border-radius: 6px; }
.stock-medio { background-color: #ffc107; color: white; padding: 6px 10px; border-radius: 6px; }
.stock-alto { background-color: #28a745; color: white; padding: 6px 10px; border-radius: 6px; }
button.editar {
    background-color: #17a2b8; color: white; border: none;
    padding: 6px 10px; border-radius: 6px; cursor: pointer;
}
button.editar:hover { background-color: #138496; }
button.eliminar {
    background-color: #dc3545; color: white; border: none;
    padding: 6px 10px; border-radius: 6px; cursor: pointer;
}
button.eliminar:hover { background-color: #b02a37; }

/* Modal */
.modal {
    display: none; 
    position: fixed; 
    z-index: 9999; 
    left: 0; top: 0; 
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5); 
}
.modal-contenido {
    background-color: white;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 420px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}
.modal-contenido h3 { margin-top: 0; }
.modal-contenido label { display: block; margin-top: 10px; font-weight: bold; }
.modal-contenido input[type="text"],
.modal-contenido input[type="number"],
.modal-contenido textarea {
    width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;
}
.modal-contenido img {
    display: block; margin: 10px auto; width: 160px; border-radius: 8px;
}
.modal-contenido button {
    margin-top: 10px; padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer;
}
.modal-contenido .guardar { background-color: #28a745; color: white; }
.modal-contenido .cerrar { background-color: #6c757d; color: white; margin-left: 10px; }
</style>
</head>
<body>
<h2>Gestión de Productos</h2>

<form class="buscador" method="GET">
    <input type="text" name="q" placeholder="Buscar por nombre o categoría..." value="<?= htmlspecialchars($busqueda) ?>">
    <button type="submit">Buscar</button>
    <?php if (!empty($busqueda)): ?>
        <a href="stock.php" style="margin-left:10px; color:#007bff; text-decoration:none;">✖ Limpiar</a>
    <?php endif; ?>
</form>

<?php if ($result->num_rows > 0): ?>
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
    <p>No hay productos cargados o no hay coincidencias con tu búsqueda.</p>
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

            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label>Precio:</label>
                    <input type="number" name="precio" id="editPrecio" step="0.01" required>
                </div>
                <div style="flex: 1;">
                    <label>Stock:</label>
                    <input type="number" name="stock" id="editStock" required>
                </div>
            </div>

            <div style="text-align: right; margin-top: 15px;">
                <button type="button" class="guardar" onclick="guardarCambios()">Guardar</button>
                <button type="button" class="cerrar" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
        <p id="mensajeModal" style="font-weight: bold; text-align:center; margin-top:10px;"></p>
    </div>
</div>

<script>
const modal = document.getElementById('modal');
const formEditar = document.getElementById('formEditar');

function abrirModal(producto) {
    modal.style.display = 'block';
    document.getElementById('editId').value = producto.id;
    document.getElementById('editNombre').value = producto.nombre;
    document.getElementById('editCategoria').value = producto.categoria;
    document.getElementById('editDescripcion').value = producto.descripcion;
    document.getElementById('editPrecio').value = producto.precio;
    document.getElementById('editStock').value = producto.stock;
    document.getElementById('editImagenPreview').src = producto.imagen;
    document.getElementById('mensajeModal').textContent = '';
}

function cerrarModal() {
    modal.style.display = 'none';
    formEditar.reset();
}

function guardarCambios() {
    const formData = new FormData(formEditar);
    fetch('update_producto.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('mensajeModal');
        msg.textContent = data.message;
        msg.style.color = data.success ? 'green' : 'red';
        if (data.success) setTimeout(() => location.reload(), 1000);
    })
    .catch(err => console.error('Error:', err));
}

function eliminarProducto(id) {
    if (!confirm('¿Seguro que querés eliminar este producto?')) return;
    fetch('borrar_producto.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`fila-${id}`).remove();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => console.error('Error:', err));
}

window.onclick = function(event) {
    if (event.target == modal) cerrarModal();
}
</script>
</body>
</html>
<?php $conn->close(); ?>
