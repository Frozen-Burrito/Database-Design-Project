<?php 
  require '../../includes/app.php';
  
  use App\Usuario;
  use App\Cliente;
  use App\Empleado;
  use App\Sucursal;
  use App\Tipo;

  verificarLogin(3);

  $tipoUsuario = filter_var($_GET['tipo'], FILTER_VALIDATE_INT);
  
  if (is_null($tipoUsuario)) {
    header("Location: " . url_for('usuarios'));
  }

  $usuario = new Usuario;
  $cuenta = $tipoUsuario == 1 ? new Empleado : new Cliente;
  $errores = [];

  $tipos = Tipo::findMany();
  $sucursales = Sucursal::findMany();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = new Usuario($_POST['usuario']);
    
    if ($tipoUsuario == 1) {
      $cuenta = new Empleado($_POST['cuenta']);
      $cuenta->idTipo = $usuario->idTipo;
    } else {
      $cuenta = new Cliente($_POST['cuenta']);
    }
     
    $errores = array_merge($usuario->validar(), $cuenta->validar());

    if (empty($errores)) {
      $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
        
      $resultado = $usuario->guardar();
      
      $usuarioCreado = Usuario::findWhere('username', $usuario->username);
      $cuenta->idUsuario = $usuarioCreado->id;
      $resultadoDatos = $cuenta->guardar();

      if ($resultado && $resultadoDatos) {
        header("Location: " . url_for('usuarios'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/usuarios/crear");
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

        <h1 class="mb-3 fw-normal">Crear Nuevo Usuario</h1>

        <?php include '../../includes/forms/form_usuario.php'; ?>

        <h2 class="mt-5 mb-3 fw-normal">
          Datos del <?php echo $tipoUsuario == 1 ? 'Empleado' : 'Cliente'; ?>
        </h2>

        <?php include '../../includes/forms/form_cuenta.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('usuarios'); ?>">
                <i class="bi bi-arrow-left-square"></i> Regresar
              </a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Guardar Usuario">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>