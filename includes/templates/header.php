<?php

if (!isset($_SESSION)) {
    session_start();
}
$auth = $_SESSION['login'] ?? false;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/Curso/bienesRaicesPHP_INICIO/build/css/app.css">
</head>

<body>

    <header class="header <?php echo $inicio  ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/Curso/bienesRaicesPHP_INICIO/">
                    <img src="/Curso/bienesRaicesPHP_INICIO/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/Curso/bienesRaicesPHP_INICIO/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/Curso/bienesRaicesPHP_INICIO/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/Curso/bienesRaicesPHP_INICIO/nosotros.php">Nosotros</a>
                        <a href="/Curso/bienesRaicesPHP_INICIO/anuncios.php">Anuncios</a>
                        <a href="/Curso/bienesRaicesPHP_INICIO/blog.php">Blog</a>
                        <a href="/Curso/bienesRaicesPHP_INICIO/contacto.php">Contacto</a>
                        <?php if ($auth) : ?>
                            <a href="/Curso/bienesRaicesPHP_INICIO/cerrar-sesion.php">Cerrar Sesion</a>
                        <?php endif; ?>
                    </nav>
                </div>

            </div> <!--.barra-->

            <?php echo $inicio ? "<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>" : ''; ?>
        </div>
    </header>