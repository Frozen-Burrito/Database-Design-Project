<?php

namespace App;

class Usuario extends Entidad {
  // DB
  protected static $tabla = 'usuario';
  protected static $columnas = [
    'id', 'email', 'username', 'password', 'idTipo'
  ];

  // Fields
  public $id;
  public $email;
  public $username;
  public $password;
  public $idTipo;

  public function __construct($args = []) 
  {
    $this->id = $args['id'] ?? null;
    $this->email = $args['email'] ?? '';
    $this->username = $args['username'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->idTipo = $args['idTipo'] ?? null;
  }

  public function validar() {
    self::$errores = [];

    if (!$this->username || strlen($this->username) > 30) {
      self::$errores[] = "El nombre de usuario es obligatorio";
    }

    if (!$this->email || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$errores[] = "El correo electrónico no es válido";
    }

    if ($this->password) {
      if (strlen($this->password) < 8 || strlen($this->password) > 20) {
        self::$errores[] = "La contraseña debe tener entre 8 y 20 caracteres";
      }
    } else {
      self::$errores[] = "La contraseña es requerida";
    }

    if (is_null($this->idTipo) || $this->idTipo == '') {
      self::$errores[] = "Elige un tipo de usuario";
    }
    
    return self::$errores;
  }
}