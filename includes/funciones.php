<?php 

define('URL_TEMPLATES', __DIR__ . '/templates');

function verificarLogin($nivel = 0, $redireccionar = true) 
{
  session_start();

  // printd($_SESSION);
  $permisosUsuario = $_SESSION['nivel'] ?? 0;

  // printd($permisosUsuario);

  if ($nivel > $permisosUsuario) {
    header('Location: ' . url_for('inicio'));
  }
}

function getNivelUsuario() {
  if (isset($_SESSION)) {
    $permisosUsuario = $_SESSION['nivel'];
    return $permisosUsuario;
  }

  return 0;
}

function incluirTemplate(string $template, bool $navegacion = true, string $ruta = '', $autenticado = null) {
  include URL_TEMPLATES . "/${template}.php";
}

function url_for($ruta, $id = -1) 
{
  $urls = [
    'inicio' => "/8_crud/index.php",
    'tienda' => "/8_crud/tienda.php",
    'cuenta' => "/8_crud/cuenta.php",
    'clientes/crear' => "/8_crud/crear_cuenta.php",
    'login' => "/8_crud/login.php",
    'logout' => "/8_crud/logout.php",

    'productos' => "/8_crud/crud/productos/",
    'productos/crear' => "/8_crud/crud/productos/crear.php",
    'productos/editar' => "/8_crud/crud/productos/editar.php?id=$id",

    'tipos' => "/8_crud/crud/tipos/",
    'tipos/crear' => "/8_crud/crud/tipos/crear.php",
    'tipos/editar' => "/8_crud/crud/tipos/editar.php?id=$id",

    'sucursales' => "/8_crud/crud/sucursales/",
    'sucursales/crear' => "/8_crud/crud/sucursales/crear.php",
    'sucursales/editar' => "/8_crud/crud/sucursales/editar.php?id=$id",
    'sucursales/inventario' => "/8_crud/crud/sucursales/inventario/?id=$id",
    'sucursales/inventario/crear' => "/8_crud/crud/sucursales/inventario/crear.php?idSucursal=$id",
    'sucursales/inventario/editar' => "/8_crud/crud/sucursales/inventario/editar.php?id=$id",

    'ordenes' => "/8_crud/ordenes/",
    'ordenes/crear' => "/8_crud/ordenes/crear.php?producto=$id",
    'ordenes/editar' => "/8_crud/ordenes/editar.php?id=$id",

    'usuarios' => "/8_crud/crud/usuarios/",
    'usuarios/crear' => "/8_crud/crud/usuarios/crear.php?tipo=$id",
    'usuarios/editar' => "/8_crud/crud/usuarios/editar.php?id=$id",
    // "properties/create" => "/bienesraices/admin/properties/create.php" 
  ];

  // printd($ruta);

  if (!array_key_exists($ruta, $urls)) {
    return '/8_crud/index.php';
  }

  return $urls[$ruta];
}

function printd($var) {
  echo "<pre>";
  var_dump($var);
  echo "</pre>";
  exit;
}

class IdCoincide {
  private $idComparado;

  function __construct($id) {
    $this->idComparado = $id;
  }

  function igual($var) {
    return $var->id == $this->idComparado;
  }
}