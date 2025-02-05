<?php 

namespace Model;

class ActiveRecord {
    
    // Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Validar los datos
    protected static $errores = [];

    public $id;

    // Definir la conexión a la base de datos
    public static function setDB($db) {
        self::$db = $db;
    }

    public function guardar() {
        if($this->id) {
            return $this->actualizar();
        } 
            
        return $this->crear();
    }

    // Crear una nueva propiedad
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Armamos la query
        $columnas = join(', ',array_keys($atributos));
        $valores = join("', '",array_values($atributos));
        $query = "INSERT INTO " . static::$tabla .  " ($columnas) VALUES ('$valores');";

        
        // Insertar en la base de datos
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Actualizar una propiedad
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "$key='$value'";
        }

        // Armamos la query
        $valores = join(", ",$valores);
        $id_sanitizado = self::$db->escape_string($this->id);
        $query = "UPDATE " . static::$tabla . " SET $valores WHERE id = $id_sanitizado LIMIT 1;";

        return self::$db->query($query);
    }

    // Eliminar una propiedad
    public function eliminar() {
        // Eliminar la propiedad
        $id_sanitizado = self::$db->escape_string($this->id);
        $query = "DELETE FROM " . static::$tabla . " WHERE id = $id_sanitizado LIMIT 1;";
        return self::$db->query($query);
    }

    // Identificar y unir los atributos de la DB
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna):
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        endforeach;

        return $atributos;
    }

    // Sanitizar los atributos
    public function sanitizarAtributos() {
        $sanitizado = [];
        $atributos = $this->atributos();

        foreach($atributos as $key => $value):
            $sanitizado[$key] = self::$db->escape_string($value);
        endforeach;

        return $sanitizado;
    }

    // Revisar los errores
    public static function getErrores() {
        return static::$errores;
    }

    // Validar los datos
    public  function validar() {
        static::$errores = [];
        return static::$errores;
    }

    public function setImagen(string $imagen) {
        throw new \Exception("setImagen() debe ser implementado por alguna clase hija");
    }
    
    public function eliminarImagen() {
        throw new \Exception("eliminarImagen() debe ser implementado por alguna clase hija");
    }

    // Listar todas las propiedades
    public static function all(): array {
        $query = "SELECT * FROM " . static::$tabla . ";";
        return self::consultarSQL($query);
    }

    // Obtiene determinado número de registros
    public static function get($cantidad): array {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT $cantidad;";
        return self::consultarSQL($query);
    }

    // Consultar una propiedad por su ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id};";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Función para consultar la base de datos y obtener los resultados
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($row = $resultado->fetch_assoc()):
            $array[] = static::crearObjeto($row);
        endwhile;

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    // Funcion auxiliar para crear un objeto de tipo Propiedad
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value): 
            if(property_exists($objeto, $key)):
                $objeto->$key = $value;
            endif;
        endforeach;
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key => $value):
            if(property_exists($this, $key)):
                $this->$key = $value;
            endif;
        endforeach;
    }
}