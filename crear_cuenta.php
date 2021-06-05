<?php 
  require './includes/app.php';
  
  use App\Usuario;
  use App\Cliente;
  use App\Tipo;

  verificarLogin();

  $usuario = new Usuario;
  $cuenta = new Cliente;
  $errores = [];

  $tipos = Tipo::findMany();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = new Usuario($_POST['usuario']);
    $cuenta = new Cliente($_POST['cuenta']);
     
    $errores = array_merge($usuario->validar(), $cuenta->validar());

    if (empty($errores)) {
      $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
        
      $resultado = $usuario->guardar();
      
      $usuarioCreado = Usuario::findWhere('username', $usuario->username);
      $cuenta->idUsuario = $usuarioCreado->id;
      $resultadoDatos = $cuenta->guardar();

      if ($resultado && $resultadoDatos) {
        $_SESSION['usuario'] = $usuario->username;
        $_SESSION['nivel'] = 1;

        header("Location: " . url_for('inicio'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crear-cuenta");
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

        <h1 class="mb-3 fw-normal">Crea una Cuenta</h1>

        <?php include './includes/forms/form_usuario.php'; ?>

        <h2 class="mt-5 mb-3 fw-normal">Datos Personales</h2>

        <?php include './includes/forms/form_cuenta.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('inicio'); ?>">
                <i class="bi bi-arrow-left-square"></i> Regresar
              </a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Crear Cuenta">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>