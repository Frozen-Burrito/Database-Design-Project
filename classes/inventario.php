<?php

namespace App;

class Inventario extends Entidad {
  // DB
  protected static $tabla = 'inventario';
  protected static $columnas = [
    'id', 'cantidad', 'idSucursal', 'idProducto'
  ];

  // Fields
  public $id;
  public $cantidad;
  public $idSucursal;
  public $idProducto;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->cantidad = $args['cantidad'] ?? 0;
    $this->idSucursal = $args['idSucursal'] ?? null;
    $this->idProducto = $args['idProducto'] ?? null;
  }

  public function validar() {
    if ($this->cantidad < 0 || $this->cantidad > 1000) {
      self::$errores[] = "El número de existencias no es válido";
    }

    if (is_null($this->idSucursal)) {
      self::$errores[] = "Por favor seleccione una sucursal";
    }

    if (is_null($this->idProducto)) {
      self::$errores[] = "Por favor seleccione un producto";
    }

    return self::$errores;
  }
}