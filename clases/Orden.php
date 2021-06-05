<?php

namespace App;

class Orden extends Entidad {
  // DB
  protected static $tabla = 'orden';
  protected static $columnas = [
    'id', 
    'fecha', 
    'fechaEntrega',
    'monto', 
    'cantidad',
    'idCliente',
    'idProducto'
  ];

  // Fields
  public $id;
  public $fecha;
  public $fechaEntrega;
  public $monto;
  public $cantidad;
  public $idCliente;
  public $idProducto;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->fecha = $args['fecha'] ?? '';
    $this->fechaEntrega = $args['fechaEntrega'] ?? '';
    $this->cantidad = $args['cantidad'] ?? 0;
    $this->monto = $args['monto'] ?? 0;
    $this->idCliente = $args['idCliente'] ?? null;
    $this->idProducto = $args['idProducto'] ?? null;;
  }

  public function validar() {
    if (strlen($this->fechaEntrega) > 0 && strlen($this->fechaEntrega) < 11) {
      // La fecha es incluida
      if ($this->fechaEntrega < $this->fecha) {
        self::$errores[] = "La fecha de entrega no puede ser antes que la fecha actual";
      }
      
    } else {
      self::$errores[] = "Por favor selecciona una fecha de entrega válida";
    }

    if ($this->cantidad < 1 || $this->cantidad > 100) {
      self::$errores[] = "La cantidad debe estar entre 1 y 100";
    }

    return self::$errores;
  }
}