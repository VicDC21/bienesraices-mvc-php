<?php 

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /login.php');
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitiza el HTML
function s($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

// Muestra los mensajes 
function mostrarNotificacion($codigo) {
    return match ($codigo) {
        1 => 'Creado Correctamente',
        2 => 'Actualizado Correctamente',
        3 => 'Eliminado Correctamente',
        default => false,
    };
}

function validarORedireccionar(string $url){
    // Validar la URL por ID válido
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: {$url}');
    }

    return $id;
}