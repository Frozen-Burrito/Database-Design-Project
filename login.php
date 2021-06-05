<?php 
  require 'includes/app.php';
  incluirTemplate('header', $navegacion = false, $ruta = 'login');
  
  use App\Usuario;

  verificarLogin();

  $errores = Usuario::getErrores();

  $username = '';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['usuario']['username'];
    $password = $_POST['usuario']['password'];

    if (!$username || strlen($username) > 30) {
      $errores[] = "Por favor añade un nombre de usuario";
    }

    if ($password) {
      if (strlen($password) < 8 || strlen($password) > 20) {
        $errores[] = "La contraseña debe tener entre 8 y 20 caracteres";
      }
    } else {
      $errores[] = "La contraseña es requerida";
    }

    if (empty($errores)) {
      // Revisar si el usuario existe
      $usuario = Usuario::findWhere('username', $username);

      if (!is_null($usuario)) {
        // Revisar que las contraseñas coincidan
        $match = password_verify($password, $usuario->password);

        if ($match) {
          // El usuario es autenticado
          if (!isset($_SESSION)) {
            session_start();
          } 

          $nivel = 1; // Cliente
          switch ($usuario->idTipo) {
            case 9:
              $nivel = 2; // Cajero
              break;
            case 10:
              $nivel = 3; // Gerente
              break; 
            case 11:
              $nivel = 3; // Admin
              break;
          }

          $_SESSION['usuario'] = $usuario->username;
          $_SESSION['nivel'] = $nivel;

          header('Location: ' . url_for('inicio'));

        } else {
          $errores[] = "La contraseña es incorrecta";
        }

      } else {
        $errores[] = "El nombre de usuario no existe. Prueba otro nombre de usuario";
      }
    }
  }
?>
<main class="form-login">

  <?php foreach ($errores as $error) : ?> 
    <div class="alert alert-danger" role="alert">
      <?php echo $error; ?>
    </div>
  <?php endforeach; ?>

  <form method="POST">
    <h1 class="h2 mb-5 fw-normal">Inicia Sesión</h1>

    <div class="form-floating mb-3">
      <input type="text" name="usuario[username]" class="form-control" id="username" value="<?php echo $username; ?>">
      <label for="username">Nombre de Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" name="usuario[password]" class="form-control" id="password">
      <label for="password">Contraseña</label>
    </div>

    <div class="container mt-3">
      <div class="row">
        <div class="col">
          <a class="btn btn-secondary" href="<?php echo url_for('inicio'); ?>"><i class="bi bi-arrow-left-square"></i> Regresar</a>
        </div>
        <div class="col">
          <input class="btn btn-primary" type="submit" value="Iniciar Sesión">
        </div>
      </div>
    </div>
  </form>
</main>
<?php incluirTemplate('footer'); ?>