<?php

namespace App;

class Cliente extends Entidad {
  // DB
  protected static $tabla = 'cliente';
  protected static $columnas = [
    'id', 
    'nombre', 
    'apellido',
    'direccion', 
    'idUsuario'
  ];

  // Fields
  public $id;
  public $nombre;
  public $apellido;
  public $direccion;
  public $idUsuario;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->direccion = $args['direccion'] ?? '';
    $this->idUsuario = $args['idUsuario'] ?? null;;
  }

  public function validar() {
    self::$errores = [];

    if (!$this->nombre) {
      self::$errores[] = "Por favor escribe tu nombre";
    }

    if (!$this->apellido) {
      self::$errores[] = "Por favor escribe tu apellido";
    }

    if (!$this->direccion) {
      self::$errores[] = "Por favor escribe la dirección de entrega";
    }

    return self::$errores;
  }
}