<?php 
  require '../../includes/app.php';
  
  use App\Sucursal;

  verificarLogin(3);

  $sucursal = new Sucursal;
  $errores = Sucursal::getErrores();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sucursal = new Sucursal($_POST['sucursal']);

    $errores = $sucursal->validar();

    if (empty($errores)) {
      $resultado = $sucursal->guardar();

      if ($resultado) {
        header("Location: " . url_for('sucursales'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/sucursales/crear");
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

        <h1 class="mb-3 fw-normal">Nueva Sucursal</h1>

        <?php include '../../includes/forms/form_sucursal.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('sucursales'); ?>"><i class="bi bi-arrow-left-square"></i> Regresar</a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Guardar Sucursal">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>