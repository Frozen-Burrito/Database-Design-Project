<?php 
  require '../includes/app.php';

  use App\Orden;
  use App\Producto;
  use App\Cliente;
  use App\Usuario;

  verificarLogin(1);

  $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

  if (!$id) {
    header("Location: " . url_for('ordenes'));
  }

  $orden = Orden::findOne($id);
  $productos = Producto::findMany();
  $usuario = Usuario::findOne($orden->idCliente);
  $cliente = Cliente::findOne($orden->idCliente);
  $errores = Orden::getErrores();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $args = $_POST['orden'];
    
    $args['fecha'] = date("Y-m-d");
    $args['monto'] = (int) $args['cantidad'] * 2;
    $args['idCliente'] = $cliente->id;
    
    $orden->aplicarCambios($args);

    $errores = $orden->validar();

    $productoExiste = array_filter($productos, array(new IdCoincide($orden->idProducto), 'igual'));

    if (empty($productoExiste)) {
      $errores[] = "Por favor selecciona un producto para la orden";
    } else {
      $orden->monto = (float) array_shift($productoExiste)->precio * (int) $orden->cantidad;
    }

    if (empty($errores)) {
      $resultado = $orden->guardar();

      if ($resultado) {
        header('Location: ' . url_for('ordenes'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/ordenes/editar");
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

        <h1 class="mb-3 fw-normal">Editar Orden</h1>

        <?php include '../includes/forms/form_orden.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('ordenes'); ?>">
              <i class="bi bi-arrow-left-square">
              </i> Regresar</a>
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