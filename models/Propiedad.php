<?php

namespace Model;

class Propiedad extends ActiveRecord {
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    protected static $tabla = 'propiedades';

    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y-m-d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    // Validar los datos
    public  function validar() {
        if(!$this->titulo) {
            self::$errores[] = 'Debes añadir un título';
        }

        if(!$this->precio) {
            self::$errores[] = 'El precio es obligatorio';
        }

        if(strlen($this->descripcion) < 50) {
            self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$this->habitaciones) {
            self::$errores[] = 'El número de habitaciones es obligatorio';
        }

        if(!$this->wc) {
            self::$errores[] = 'El número de baños es obligatorio';
        }

        if(!$this->estacionamiento) {
            self::$errores[] = 'El número de lugares de estacionamientos es obligatorio';
        }

        if(!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        } 

        if(!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }

    // Define la ruta de la imagen de la propiedad
    public function setImagen(string $imagen) {
        // Eliminar la imagen previa (si existe)
        $this->eliminarImagen();

        // Asoignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Elimina la imagen del servidor
    public function eliminarImagen() {
        if($this->id) {
            // Comprobar si la imagen existe
            if(file_exists(CARPETA_IMAGENES . $this->imagen)){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
    }
}