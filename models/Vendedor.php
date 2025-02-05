<?php

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];
    protected static $tabla = 'vendedores';

    public $nombre;
    public $apellido;
    public $telefono;

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    // Validar los datos
    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = 'El nombre es obligatorio';
        }

        if(!$this->apellido) {
            self::$errores[] = 'El apellido es obligatorio';
        }

        if(!$this->telefono) {
            self::$errores[] = 'El teléfono es obligatorio';
        }

        if(!preg_match('/[0-9]{10}/', $this->telefono) || strlen($this->telefono) != 10) {
            self::$errores[] = 'Formato de teléfono no válido, deben ser 10 dígitos';
        }

        return self::$errores;
    }
}