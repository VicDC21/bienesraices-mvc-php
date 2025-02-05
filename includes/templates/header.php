<?php
    if(!isset($_SESSION)){
        session_start();
    }    

    $auth = $_SESSION["login"] ?? null;
    if(!isset($inicio)){
        $inicio = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>

    <link rel="preload" href="/build/css/app.css" as="style">
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="imagen logo bienes raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img src="/build/img/dark-mode.svg" alt="imagen dark mode" class="dark-mode-boton">    
                    <nav class="navegacion">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/propiedades">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a> 
                        <?php if($auth): ?>
                            <a href="/logout">Cerrar Sesión</a>
                        <?php endif; ?>               
                    </nav>
                </div>
            </div>
            <?php 
                echo $inicio ? '<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>' :'';
            ?>
        </div>
    </header>