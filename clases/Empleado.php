<?php

namespace App;

class Empleado extends Entidad {
  // DB
  protected static $tabla = 'empleado';
  protected static $columnas = [
    'id', 
    'nomina',
    'nombre', 
    'apellido',
    'sueldo',
    'idSucursal',
    'idTipo', 
    'idUsuario'
  ];

  // Fields
  public $id;
  public $nomina;
  public $nombre;
  public $apellido;
  public $sueldo;
  public $idSucursal;
  public $idTipo;
  public $idUsuario;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->nomina = $args['nomina'] ?? 0;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->sueldo = $args['sueldo'] ?? '';
    $this->idSucursal = $args['idSucursal'] ?? null;;
    $this->idTipo = $args['idTipo'] ?? null;;
    $this->idUsuario = $args['idUsuario'] ?? null;;
  }

  public function validar() {
    self::$errores = [];

    
    if (!$this->nombre || strlen($this->nombre) > 20) {
      self::$errores[] = "Por favor escribe tu nombre";
    }

    if (!$this->apellido || strlen($this->apellido) > 25) {
      self::$errores[] = "Por favor escribe tu apellido";
    }

    if ($this->nomina < 0 || $this->nomina > 9999) {
      self::$errores[] = "La nómina debe se un número entre 0 y 9999 (Cuatro dígitos)";
    }

    if ($this->sueldo < 0 || $this->sueldo > 1000000) {
      self::$errores[] = "El sueldo debe estar entre $0 y $1,000,000 (Mensuales)";
    }

    if (is_null($this->idSucursal) || $this->idSucursal == '') {
      self::$errores[] = "Asigna el empleado a una sucursal";
    }

    return self::$errores;
  }
}