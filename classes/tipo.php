<?php

namespace App;

class Tipo extends Entidad {
  // DB
  protected static $tabla = 'tipo';
  protected static $columnas = [
    'id', 'nombre', 'categoria'
  ];
  static $categorias = [
    "Productos",
    "Empleados",
    "Usuarios"
  ];

  // Fields
  public $id;
  public $nombre;
  public $categoria;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->categoria = $args['categoria'] ?? -1;
  }

  public function validar() {
    if (!$this->nombre || strlen($this->nombre) > 30) {
      self::$errores[] = "El nombre del tipo es obligatorio y debe tener menos de 30 caracteres";
    }

    if ($this->categoria < 0 || $this->categoria > count(self::$categorias)) {
      self::$errores[] = "La categoría no es válida";
    }

    return self::$errores;
  }
}