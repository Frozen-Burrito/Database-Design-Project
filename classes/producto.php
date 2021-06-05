<?php

namespace App;

class Producto extends Entidad {
  // DB
  protected static $tabla = 'producto';
  protected static $columnas = [
    'id', 'nombre', 'precio', 'descripcion', 'idTipo'
  ];

  // Fields
  public $id;
  public $nombre;
  public $precio;
  public $descripcion;
  public $idTipo;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->precio = $args['precio'] ?? 0;
    $this->descripcion = $args['descripcion'] ?? '';
    $this->idTipo = $args['idTipo'] ?? null;;
  }

  public function validar() {
    if (!$this->nombre) {
      self::$errores[] = "El nombre del producto es obligatorio";
    } else if (strlen($this->nombre) > 30) {
      self:$errores[] = "El nombre es muy largo, debe tener una longitud menor a 30";
    }

    if ($this->precio <= 0 || $this->precio > 1000000) {
      self::$errores[] = "El precio debe estar entre $0 y $1,000,000";
    }

    if ($this->descripcion != '') {
      if (strlen($this->descripcion) < 30) {
        self::$errores[] = "La descripción es muy corta";
      } else if (strlen($this->descripcion) > 200) {
        self::$errores[] = "La descripción debe tener menos de 200 caracteres";
      }
    } 

    return self::$errores;
  }
}