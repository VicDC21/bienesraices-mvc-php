<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Classes\Mail;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render("paginas/index", [
            "propiedades"=> $propiedades,
            "inicio"=> $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render("paginas/nosotros");
    }

    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();
        $router->render("paginas/propiedades", [
            "propiedades"=> $propiedades
        ]);
    }
    
    public static function propiedad(Router $router) {
        $id = validarORedireccionar('/propiedades');    
        $propiedad = Propiedad::find($id);

        $router->render("paginas/propiedad", [
            "propiedad"=> $propiedad
        ]);
    }

    public static function blog(Router $router) {
        $router->render("paginas/blog", []);
    }

    public static function entrada(Router $router) {
        $router->render("paginas/entrada", []);
    }

    public static function contacto(Router $router) {
        $mensaje = null;   
        $error = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST") { 
            $mail = new Mail();

            $mail->setData();
            $mail->setContent();
            
            if($mail->send()){
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
                $error = true;
            }
        }

        $router->render("paginas/contacto", [
            "mensaje"=> $mensaje,
            "error"=> $error
        ]);
    }
}