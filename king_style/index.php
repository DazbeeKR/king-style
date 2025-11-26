<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Style - Tienda de Indumentaria</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head> 
<body>

<?php include "navegacion/barra_navegacion.php"; ?>

<div class="hero-carousel">

    <div class="carousel-track">
        <div class="slide">
            <img src="imgProductos/banner1.png" alt="Colección King Style">
        </div>
        <div class="slide">
            <img src="imgProductos/banner2.png" alt="Nueva Temporada">
        </div>
        <div class="slide">
            <img src="imgProductos/banner3.png" alt="Moda Premium">
        </div>
    </div>

    <button class="carousel-btn prev">❮</button>
    <button class="carousel-btn next">❯</button>

    <div class="carousel-indicators">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

</div>

<section class="featured-products">
    <div id="contenido">
        <?php include "mostrar.php"; ?>
    </div>
</section>

<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="2yqYvgy_EV2tRT4bkNilv";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>

<div id="footer">
    <?php include "navegacion/footer.html"; ?>
</div>

<script src="script.js"></script>
</body>
</html>
