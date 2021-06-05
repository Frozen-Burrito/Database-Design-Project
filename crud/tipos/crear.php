<?php 
  require '../../includes/app.php';

  use App\Tipo;

  verificarLogin(3);

  $tipo = new Tipo;
  $categorias = Tipo::$categorias;
  $errores = Tipo::getErrores();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo = new Tipo($_POST['tipo']);

    $errores = $tipo->validar();

    if (empty($errores)) {
      $resultado = $tipo->guardar();

      if ($resultado) {
        $url = url_for('tipos');
        header("Location: {$url}");
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/tipos/editar");
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

        <h1 class="mb-3 fw-normal">Crea un Tipo</h1>

        <?php include '../../includes/forms/form_tipo.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('tipos'); ?>"><i class="bi bi-arrow-left-square"></i> Regresar</a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Guardar Tipo">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>