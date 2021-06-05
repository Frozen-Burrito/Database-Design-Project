<?php 
  require '../../includes/app.php';

  use App\Tipo;

  verificarLogin(3);

  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

  if (!$id) {
    $url = url_for('tipos');
    header("Location: {$url}");
  }

  $tipo = Tipo::findOne($id);
  $categorias = Tipo::$categorias;
  $errores = Tipo::getErrores();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $args = $_POST['tipo'];
    $tipo->aplicarCambios($args);

    $errores = $tipo->validar();

    if (empty($errores)) {
      $resultado = $tipo->guardar();

      if ($resultado) {
        header('Location: ' . url_for('tipos'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/tipos/editar");
?>
<main class="form-login" class="center-all">
  <form method="POST">
    <div class="card center-all">
      <div class="card-body">
        
        <?php foreach ($errores as $error) : ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endforeach; ?>

        <h1 class="mb-3 fw-normal">Editar Tipo</h1>

        <?php include '../../includes/forms/form_tipo.php'; ?>

        <div class="container mt-3">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('tipos'); ?>"><i class="bi bi-arrow-left-square"></i> Regresar</a>
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