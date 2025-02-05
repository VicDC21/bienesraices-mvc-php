<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class PropiedadController {

    public static function index(Router $router) {
        // Consulta para obtener las propiedades
        $propiedades = Propiedad::all();

        // Consulta para obtener los vendedores
        $vendedores = Vendedor::all();
        
        // Mostar mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades'=> $propiedades,
            'resultado' => $resultado,
            'vendedores'=> $vendedores
        ]);
    }

    public static function crear(Router $router) {
        $propiedad = new Propiedad();
        
        // Consulta para obtener los vendedores
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // Crear una nueva instancia
            $propiedad = new Propiedad($_POST);  
    
            // Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['imagen']['tmp_name']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            
            // Validar que no haya errores
            $errores = $propiedad->validar();
    
            // Revisar que el array de errores esté vacío
            if(empty($errores)) {       
                // Insertar en la base de datos        
                if($propiedad->guardar()) {
                    // Crear carpeta si no existe
                    if(!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES);
                    }
    
                    // Subir la imagen
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
    
                    // Redireccionar al usuario
                    header('Location: /admin?resultado=1');
                }
            }
        }

        $router->render('propiedades/crear', [
            'propiedad'=> $propiedad,
            'vendedores'=> $vendedores,
            'errores'=> $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        
        // Consulta para obtener los datos de la propiedad
        $propiedad = Propiedad::find($id);
        
        // Consulta para obtener los vendedores
        $vendedores = Vendedor::all();
        
        // Array con mensajes de errores
        $errores = Propiedad::getErrores();
        
        // Ejectuar el código después de que el usuario envía el formulario
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            // Asignar los atributos
            $propiedad->sincronizar($_POST);

            // Validación
            $errores = $propiedad->validar();

            // Subida de archivos
            // Generar un nombre único
            if($_FILES['imagen']['tmp_name']) {
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            } 

            // Revisar que el array de errores esté vacío
            if(empty($errores)) {       
                // Insertar en la base de datos     
                if($propiedad->guardar()) {
                    // Subir la imagen
                    if(isset($imagen, $nombreImagen)) {
                        $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                    }
                    // Redireccionar al usuario
                    header('Location: /admin?resultado=2');
                }
            }
        }

        
        $router->render('propiedades/actualizar', [
            'propiedad'=> $propiedad,
            'vendedores'=> $vendedores,
            'errores'=> $errores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === "POST" && validarTipoContenido($_POST['tipo'])) {
            // Validar el ID
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            // Eliminar el registro de la base de datos
            $propiedad = Propiedad::find($id);
            $propiedad->eliminar();
            $propiedad->eliminarImagen();
            header('Location: /admin?resultado=3');
        }
    }
}