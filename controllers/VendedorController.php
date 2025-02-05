<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear(Router $router) {        
        $vendedor =  new Vendedor();
        $errores = Vendedor::getErrores();
    
        // Ejectuar el código después de que el usuario envía el formulario
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $vendedor = new Vendedor($_POST);  
            $errores = $vendedor->validar();
    
            // Revisar que el array de errores esté vacío
            if(empty($errores)) {       
                // Insertar en la base de datos        
                $vendedor->guardar();
                    
                // Redireccionar al usuario
                header('Location: /admin?resultado=1');
            }
        }

        $router->render('vendedores/crear', [
            'vendedor'=> $vendedor,
            'errores'=> $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        
        // Consulta para obtener los datos del vendedor
        $vendedor = Vendedor::find($id);

        // Array con mensajes de errores
        $errores = Vendedor::getErrores();
        
        // Ejectuar el código después de que el usuario envía el formulario
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // Asignar los atributos
            $vendedor->sincronizar($_POST);

            // Validación
            $errores = $vendedor->validar();

            // Revisar que el array de errores esté vacío
            if(empty($errores)) {       
                // Insertar en la base de datos        
                $vendedor->guardar();
                    
                // Redireccionar al usuario
                header('Location: /admin?resultado=2');
            }
        }
        
        $router->render('vendedores/actualizar', [
            'vendedor'=> $vendedor,
            'errores'=> $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === "POST" && validarTipoContenido($_POST['tipo'])) {
            // Validar el ID
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            // Eliminar el registro de la base de datos
            $vendedor = Vendedor::find($id);
            $vendedor->eliminar();
            header('Location: /admin?resultado=3');
        }
    }
}