<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="header-top">
        <div class="logo">
            <a href="index.php"><img src="imgProductos/king_style_logo.png" alt="Logo King Style"></a>
        </div>

        <div class="search-bar">
            <form action="buscar.php" method="GET">
                <input type="text" name="q" placeholder="Buscar ropa, marcas y más..." required>
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="header-icons">

            <a href="carrito.php" class="btn-header">Carrito</a>

            <div class="user-menu">
                <?php if (isset($_SESSION['email_usuario'])): ?>

                    <div class="user-dropdown">
                        <img src="imgProductos/user-icon.jpg" class="user-icon" id="userIcon">

                        <div class="dropdown-content" id="dropdownMenu">
                            <a href="perfil.php">Mi perfil</a>
                            <a href="logout.php" class="cerrar-sesion">Cerrar sesión</a>
                        </div>
                    </div>

                <?php else: ?>

                    <a href="login.php" class="btn-header">Perfil</a>

                <?php endif; ?>
            </div>

        </div>
    </div>

    <nav class="header-nav">
        <ul>
            <li><a href="buscar.php?q=Remeras">Remeras</a></li>
            <li><a href="buscar.php?q=Pantalones">Pantalones</a></li>
            <li><a href="buscar.php?q=Shorts">Shorts</a></li>
            <li><a href="buscar.php?q=Ropa Interior">Ropa Interior</a></li>
            <li><a href="buscar.php?q=Accesorios">Accesorios</a></li>
        </ul>
    </nav>
</header>