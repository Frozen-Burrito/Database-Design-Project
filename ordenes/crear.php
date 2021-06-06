<?php 
  require '../includes/app.php';
  
  use App\Orden;
  use App\Producto;
  use App\Cliente;
  use App\Usuario;

  verificarLogin(1);

  $orden = new Orden;
  $productos = Producto::findMany();
  $usuario = Usuario::findWhere('username', $_SESSION['usuario']);
  $cliente = Cliente::findWhere('idUsuario', $usuario->id);
  $errores = Orden::getErrores();

  $idProducto = filter_var($_GET['producto'] ?? null, FILTER_VALIDATE_INT);

  if ($idProducto) {
    $orden->idProducto = $idProducto;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $args = $_POST['orden'];

    $args['fecha'] = date("Y-m-d");
    $args['monto'] = $args['cantidad'] * 2;
    $args['idCliente'] = $cliente->id;

    $orden = new Orden($args);

    $errores = $orden->validar();

    $productoExiste = array_filter($productos, array(new IdCoincide($orden->idProducto), 'igual'));

    if (empty($productoExiste)) {
      $errores[] = "Por favor selecciona un producto para la orden";
    } else {
      $orden->monto = array_shift($productoExiste)->precio * $orden->cantidad;
    }

    if (empty($errores)) {
      $resultado = $orden->guardar();

      if ($resultado) {
        header("Location: " . url_for('ordenes'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/ordenes/crear");
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

        <h1 class="mb-3 fw-normal">Nueva Orden</h1>

        <?php include '../includes/forms/form_orden.php'; ?>

        <div class="container mt-5">
          <div class="row">
            <div class="col">
              <a class="btn btn-secondary" href="<?php echo url_for('ordenes'); ?>">
              <i class="bi bi-arrow-left-square">
              </i> Regresar</a>
            </div>
            <div class="col">
              <input class="btn btn-primary" type="submit" value="Guardar Orden">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>

<?php incluirTemplate('footer'); ?>