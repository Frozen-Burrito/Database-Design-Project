<?php

namespace App;

class Sucursal extends Entidad {
  // DB
  protected static $tabla = 'sucursal';
  protected static $columnas = [
    'id', 'direccion'
  ];

  // Fields
  public $id;
  public $direccion;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->direccion = $args['direccion'] ?? '';
  }

  public function validar() {
    if (!$this->direccion) {
      self::$errores[] = "Por favor especifica una dirección para la sucursal";
    } else if (strlen($this->direccion) > 50) {
      self::$errores[] = "La dirección no debe tener más de 50 caracteres";
    }

    return self::$errores;
  }
}