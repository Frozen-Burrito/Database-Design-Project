<?php 
  require '../../includes/app.php';

  use App\Usuario;
  use App\Cliente;
  use App\Empleado;
  use App\Sucursal;
  use App\Tipo;

  verificarLogin(3);

  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

  if (!$id) {
    header("Location: " . url_for('productos'));
  }

  $usuario = Usuario::findOne($id);
  $errores = Usuario::getErrores();
  $cuenta = null;

  if($usuario->idTipo > 8 && $usuario->idTipo < 12) {
    $cuenta = Empleado::findWhere('idUsuario', $id);
  } else {
    $cuenta = Cliente::findWhere('idUsuario', $id);
  }

  $tipos = Tipo::findMany();
  $sucursales = Sucursal::findMany();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario->aplicarCambios($_POST['usuario']);
    $cuenta->aplicarCambios($_POST['cuenta']);

    $errores = array_merge($usuario->validar(), $cuenta->validar());

    // printd($cuenta);

    if (empty($errores)) {
      $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);

      $resultado = $usuario->guardar();
      $resultadoDatos = $cuenta->guardar();

      if ($resultado && $resultadoDatos) {
        header("Location: " . url_for('usuarios'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/usuarios/editar");
?>
<main class="form-login">
  <form method="POST" class="mt-5">
    <div class="card center-all">
      <div class="card-body">
        <?php foreach ($errores as $error) : ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endforeach; ?>

        <h1 class="mb-3 fw-normal">Editar Usuario</h1>

        <?php include '../../includes/forms/form_usuario.php'; ?>

        <h2 class="mt-5 mb-3 fw-normal">
          Datos del <?php echo $usuario->idTipo > 8 && $usuario->idTipo < 12 ? 'Empleado' : 'Cliente'; ?>
        </h2>

        <?php include '../../includes/forms/form_cuenta.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('usuarios'); ?>"><i class="bi bi-arrow-left-square"></i> Regresar</a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Guardar Cambios">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>