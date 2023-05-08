<?php

namespace App;


class ActiveRecord
{
    //CONECCION A LA DB
    protected static $db;
    protected static $tabla = '';
    protected static $columnaDB = [];
    protected static $errores = [];


    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        if ($this->id) {
            $this->actualizarDB();
        } else {
            $this->guardarBd();
        }
    }

    public function actualizarDB()
    {
        $atributos = $this->sanitizar();

        $valores = [];  //ARRAY QUE SE CONCATENA PARA HACER LA CONSULTA 
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '";
        $query .= self::$db->escape_string($this->id) . "'";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: ../?mensaje=2');
        }
    }

    public function guardarBd()
    {
        $atributos = $this->sanitizar();

        // JOIN GENERA CONVIERTE LOS DATOS DE UN STRING SEPARADOS POR LO QUE DICE ENTRE LOS ""

        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(", ", array_keys($atributos));
        $query .= ") VALUES ( '";
        $query .= join("', '", array_values($atributos)) . " ')";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: ../?mensaje=1');
        }
    }

    public function eliminarBD()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id);

        $resultado = self::$db->query($query);

        $this->dropImage();

        if ($resultado) {
            header('Location: ./?mensaje=3');
        }
    }

    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnaDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizar()
    {
        $sanitizado = [];
        $atributos = $this->atributos();

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    public function setImage($imagen)
    {
        if ($this->id) {
            $this->dropImage();
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    public function dropImage()
    {
        if (file_exists(CARPETA_IMAGEN . $this->imagen)) {
            unlink(CARPETA_IMAGEN . $this->imagen);
        }
    }

    //BUSCAR POR ID EN LA DB
    public static function forId($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);     //RETORNA EL PRIMER ELEMENTO DE UN ARRAY
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }


        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args)
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
