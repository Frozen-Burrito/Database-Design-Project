<?php

namespace App;

use PDO;

class Entidad {
  // Base de datos
  protected static $db;
  protected static $columnas = [];
  protected static $tabla = '';

  protected static $errores = [];

  public static function setDB($db) 
  {
    self::$db = $db;
  }
  
  public function guardar() 
  {
    $campoId = static::$columnas[0];
    if (is_null($this->$campoId)) {
      return $this->crear();
    } else {
      return $this->actualizar();
    }
  }

  public function crear()
  {
    $atributos = $this->limpiarDatos();

    // Build query
    $query = "INSERT INTO " . static::$tabla . " ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES ('";
    $query .= join("', '", array_values($atributos));
    $query .= "')";

    $resultado = self::$db->query($query);

    return $resultado;
  }

  public function actualizar()
  {
    $campoId = static::$columnas[0];
    $atributos = $this->limpiarDatos();

    $valores = [];
    foreach($atributos as $campo => $valor) {
      $valores[] = "{$campo}='{$valor}'";
    }

    $query = "UPDATE " . static::$tabla . " SET ";
    $query .= join(', ', $valores);
    $query .= " WHERE " . $campoId . " = '" . $this->$campoId . "'";
    $query .= " LIMIT 1 ";

    $resultado = self::$db->query($query);

    return $resultado;
  }

  public static function findMany($limit = 0) 
  {
    $queryLimit = $limit > 0 ? " LIMIT " . $limit : "";
    $query = "SELECT * FROM " . static::$tabla . $queryLimit;
    
    $resultado = self::selectSQL($query);
    return $resultado;
  }

  public static function findOne($id) 
  {
    $campoId = static::$columnas[0];
    $query = "SELECT * FROM " . static::$tabla . " WHERE " . $campoId . " = " . $id. " LIMIT 1";

    $resultado = self::selectSQL($query);
    return array_shift($resultado);
  }

  public static function findWhere($campo, $valor, $limit = 1) 
  {
    $query = "SELECT * FROM " . static::$tabla . " WHERE " . $campo . " = '" . $valor . "' LIMIT " . $limit;

    $resultado = self::selectSQL($query);
    return array_shift($resultado);
  }

  public function delete() 
  {
    $campoId = static::$columnas[0];
    $query = "DELETE FROM " . static::$tabla . " WHERE " . $campoId . " = " . $this->$campoId . " LIMIT 1";

    $resultado = self::$db->query($query);

    return $resultado;
  }

  public static function selectSQL($query) {
    $resultado = self::$db->query($query)->fetchAll(PDO::FETCH_ASSOC);

    $lista = [];
    foreach($resultado as $row) {
      $lista[] = static::crearObjeto($row);
    } 

    return $lista;
  }

  protected static function crearObjeto($row) {
    $objeto = new static;

    foreach($row as $campo => $valor) {
      if (property_exists($objeto, $campo)) {
        $objeto->$campo = $valor;
      }
    }

    return $objeto;
  }

  public static function getErrores() {
    return self::$errores;
  }

  public function aplicarCambios($datos = []) 
  {
    foreach($datos as $campo => $valor) {
      if (property_exists($this, $campo) && !is_null($valor)) {
        $this->$campo = $valor;
      }
    }
  }

  public function limpiarDatos() 
  {
    $atributos = $this->atributos();
    $datos = [];

    foreach($atributos as $campo => $valor) {
      // TODO: Escape string
      // $datos[$campo] = self::$db->quote($valor);
      $datos[$campo] = $valor;
    }

    return $datos;
  }

  public function atributos() 
  {
    $atributos = [];

    foreach (static::$columnas as $columna) {
      if ($columna === 'id') continue;

      $atributos[$columna] = $this->$columna;
    }

    return $atributos;
  }
}