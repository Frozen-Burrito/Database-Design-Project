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
    'inicio' => "/index.php",
    'tienda' => "/tienda.php",
    'cuenta' => "/cuenta.php",
    'clientes/crear' => "/crear_cuenta.php",
    'login' => "/login.php",
    'logout' => "/logout.php",

    'productos' => "/crud/productos/",
    'productos/crear' => "/crud/productos/crear.php",
    'productos/editar' => "/crud/productos/editar.php?id=$id",

    'tipos' => "/crud/tipos/",
    'tipos/crear' => "/crud/tipos/crear.php",
    'tipos/editar' => "/crud/tipos/editar.php?id=$id",

    'sucursales' => "/crud/sucursales/",
    'sucursales/crear' => "/crud/sucursales/crear.php",
    'sucursales/editar' => "/crud/sucursales/editar.php?id=$id",
    'sucursales/inventario' => "/crud/sucursales/inventario/?id=$id",
    'sucursales/inventario/crear' => "/crud/sucursales/inventario/crear.php?idSucursal=$id",
    'sucursales/inventario/editar' => "/crud/sucursales/inventario/editar.php?id=$id",

    'ordenes' => "/ordenes/",
    'ordenes/crear' => "/ordenes/crear.php?producto=$id",
    'ordenes/editar' => "/ordenes/editar.php?id=$id",

    'usuarios' => "/crud/usuarios/",
    'usuarios/crear' => "/crud/usuarios/crear.php?tipo=$id",
    'usuarios/editar' => "/crud/usuarios/editar.php?id=$id",
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