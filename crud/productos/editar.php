<?php 
  require '../../includes/app.php';

  use App\Producto;
  use App\Tipo;

  verificarLogin(2);

  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

  if (!$id) {
    header("Location: " . url_for('productos'));
  }

  $producto = Producto::findOne($id);
  $tipos = Tipo::findMany();

  $errores = Producto::getErrores();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $args = $_POST['producto'];
    $producto->aplicarCambios($args);

    $errores = $producto->validar();

    $tipoExiste = array_filter($tipos, array(new IdCoincide($producto->idTipo), 'igual'));

    if (empty($tipoExiste)) {
      $errores[] = "Por favor selecciona un tipo de producto válido";
    }

    if (empty($errores)) {
      $resultado = $producto->guardar();

      if ($resultado) {
        header('Location: ' . url_for('productos'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/productos/editar");
?>
<main class="form-login" class="center-all">
  <form method="POST" class="mt-5">
    <div class="card center-all">
      <div class="card-body">
        <?php foreach ($errores as $error) : ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endforeach; ?>

        <h1 class="mb-3 fw-normal">Editar Producto</h1>

        <?php include '../../includes/forms/form_producto.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('productos'); ?>"><i class="bi bi-arrow-left-square"></i> Regresar</a>
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