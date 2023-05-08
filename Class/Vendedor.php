<?php

namespace App;

class Vendedor extends ActiveRecord
{
    protected static $tabla = 'vendedores';
    protected static $columnaDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($arg = [])
    {
        $this->id = $arg['id'] ?? '';
        $this->nombre = $arg['nombre'] ?? '';
        $this->apellido = $arg['apellido'] ?? '';
        $this->telefono = $arg['telefono'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre";
        }
        if (!$this->apellido) {
            self::$errores[] = 'Debes añadir un apellido';
        }
        if (!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = 'Ingresa un numero de telefono valido';
        }
        if (!$this->telefono) {
            self::$errores[] = 'El numero de telefono es obligatorio';
        }
        return self::$errores;
    }
}
