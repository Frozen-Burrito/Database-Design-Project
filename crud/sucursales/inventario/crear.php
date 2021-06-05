<?php 
  require '../../../includes/app.php';
  
  use App\Inventario;
  use App\Producto;
  use App\Sucursal;

  verificarLogin(2);

  $inventario = new Inventario;
  $productos = Producto::findMany();
  $sucursales = Sucursal::findMany();
  $errores = Inventario::getErrores();

  $idSucursal = filter_var($_GET['idSucursal'] ?? null, FILTER_VALIDATE_INT);

  if ($idSucursal) {
    $inventario->idSucursal = $idSucursal;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $inventario = new Inventario($_POST['inventario']);

    $errores = $inventario->validar();

    $productoExiste = array_filter($productos, array(new IdCoincide($inventario->idProducto), 'igual'));

    if (empty($productoExiste)) {
      $errores[] = "Por favor selecciona un producto para la orden";
    }

    $sucursalExiste = array_filter($sucursales, array(new IdCoincide($inventario->idSucursal), 'igual'));

    if (empty($sucursalExiste)) {
      $errores[] = "Por favor selecciona una sucursal para la orden";
    }

    if (empty($errores)) {
      $resultado = $inventario->guardar();

      if ($resultado) {
        header("Location: " . url_for('sucursales/inventario', $idSucursal));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/sucursales/inventario/crear");
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

        <h1 class="mb-3 fw-normal">Añadir Existencias</h1>

        <?php include '../../../includes/forms/form_inventario.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('sucursales/inventario'); ?>">
              <i class="bi bi-arrow-left-square">
              </i> Regresar</a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Confirmar">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>