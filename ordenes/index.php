<?php 
  require '../includes/app.php';

  use App\Orden;
  use App\Producto;
  use App\Usuario;

  verificarLogin(1);

  $nivel = getNivelUsuario();

  $ordenes = Orden::findMany();
  $usuario = Usuario::findWhere('username', $_SESSION['usuario']);
  $productos = Producto::findMany();

  $ordenesFiltradas = [];
  $productosPorId = [];
  foreach($productos as $producto) {
    $productosPorId[$producto->id] = $producto->nombre;
  }

  $mensaje = 'Aqui puedes ver todas las órdenes que has realizado.';

  switch ($nivel) {
    case 1:
      foreach($ordenes as $orden) {
        if ($orden->idCliente == $usuario->id) {
          $ordenesFiltradas[] = $orden;
        }
      }
      $ordenes = $ordenesFiltradas;
      break;
    case 3: 
      $mensaje = 'En esta lista se muestran todas las órdenes de la tienda.';
      break;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var($_POST["idRegistro"], FILTER_VALIDATE_INT);

    if ($id) {
      $orden = Orden::findOne($id);
      $resultado = $orden->delete();

      if ($resultado) {
        header('Location: ' . url_for('ordenes'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/ordenes");
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4"><?php echo $nivel < 2 ? 'Tus' : ''; ?> Órdenes</h1>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <a href="<?php echo url_for('ordenes/crear'); ?>">
          <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Nueva Orden
          </button>
        </a>
      </div>
    </div>

    <p><?php echo $mensaje; ?></p>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Fecha</th>
        <th scope="col">Fecha de Entrega</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Total</th>
        <th scope="col">Producto</th>
        <th scope="col">Cliente</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ordenes as $row): ?>
        <tr>
          <th scope="row"><?php echo $row->id; ?></th>
          <td><?php echo $row->fecha; ?></td>
          <td><?php echo $row->fechaEntrega; ?></td>
          <td><?php echo $row->cantidad; ?></td>
          <td>$<?php echo $row->monto; ?> MXN</td>
          <td><?php echo $productosPorId[$row->idProducto]; ?></td>
          <td class="<?php echo $usuario->id == $row->idCliente ? 'text-primary' : ''; ?>">
            <?php if($usuario->id == $row->idCliente) : ?>
              <i class="bi bi-person-fill"></i>
              <?php echo $usuario->username; ?>
            <?php else : ?>
              <?php echo $row->idCliente; ?>
            <?php endif; ?>
          </td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <a class="me-2" href="<?php echo url_for('ordenes/editar', $row->id); ?>">
                <button type="button" class="btn btn-info"><i class="bi bi-pencil-fill"></i></button>
              </a>

              <form method="POST">
                <input type="hidden" name="idRegistro" value="<?php echo $row->id; ?>" />
                <input type="submit" class="btn btn-danger" value="Eliminar"/>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="<?php echo url_for('inicio'); ?>">
    <button type="button" class="btn btn-secondary">Regresar</button>
  </a>
</section>



<?php incluirTemplate('footer'); ?>