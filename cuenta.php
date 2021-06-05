<?php 
  require 'includes/app.php';

  use App\Usuario;
  use App\Cliente;
  use App\Empleado;
  use App\Sucursal;

  verificarLogin(1);

  $cuenta = null;
  $usuario = null;
  $sucursales = Sucursal::findMany();
  $pagCuenta = true;
  $errores = [];

  if(array_key_exists('usuario', $_SESSION)) {
    $usuario = Usuario::findWhere('username', $_SESSION['usuario']);

    if (!is_null($usuario)) {
      if ($usuario->idTipo == 8) {
        $cuenta = Cliente::findWhere('idUsuario', $usuario->id);
      } else if ($usuario->idTipo > 8 && $usuario->idTipo < 12) {
        $cuenta = Empleado::findWhere('idUsuario', $usuario->id);
      }
    }
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $args = $_POST['cuenta'];

    if ($cuenta instanceof App\Empleado) {
      $args['nomina'] = $cuenta->nomina;
      $args['sueldo'] = $cuenta->nomina;
      $args['idSucursal'] = $cuenta->idSucursal;
      $args['idTipo'] = $cuenta->idTipo;
      $args['idUsuario'] = $cuenta->idUsuario;
    }
    
    $cuenta->aplicarCambios($args);

    $errores = $cuenta->validar();

    if (empty($errores)) {
      $resultado = $cuenta->guardar();

      if ($resultado) {
        header('Location: ' . url_for('cuenta'));
      }
    }
  }

  incluirTemplate('header', $ruta = "cuenta");
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Tu Cuenta</h1>
      </div>
    </div>

    <p>Aqui puedes ver, cambiar y eliminar los datos personales que almacenamos.</p>
  </div>

  <?php if(!is_null($usuario) && !is_null($cuenta)) : ?>
  <div>
    <div class="row">
      <div class="col-4">
        <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.2KdMLsskO-By1dqK2epgegHaHa%26pid%3DApi&f=1" class="card-img-top" alt="Imagen de relleno">
      </div>
      <div class="col-8">
        <form method="POST">

        <?php foreach ($errores as $error) : ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endforeach; ?>

        <h1 class="mb-3 fw-normal">Datos Personales</h1>

        <?php include 'includes/forms/form_cuenta.php'; ?>

        <div class="container mt-3">
          <input class="btn btn-primary" type="submit" value="Guardar Cambios">
        </div>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>
</section>



<?php incluirTemplate('footer'); ?>