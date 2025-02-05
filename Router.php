<?php

namespace MVC;

class Router {
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {
        session_start();
        $auth = $_SESSION["login"] ?? null;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        } else if($urlActual === '/login' && $auth) {
            header('Location: /admin');
        }
        
        if($fn) {
            // La ruta existe y se ejecuta la función asociada
            call_user_func($fn, $this);
        } else {
            echo "Página no encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos =[]) {
        foreach($datos as $key => $value) {
            $$key = $value; // Variable de variable
        }

        ob_start(); // Inicia el almacenamiento en memoria
        
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el buffer para evitar colapsar el servidor
        include __DIR__ . "/views/layout.php";
    }
}
