<?php 
  require '../../../includes/app.php';

  use App\Inventario;
  use App\Sucursal;
  use App\Producto;

  verificarLogin(2);

  $idSucursal = filter_var($_GET['id'], FILTER_VALIDATE_INT);

  if (!$idSucursal) {
    header("Location: " . url_for('sucursales'));
  }

  $inventario = Inventario::findMany();
  $sucursal = Sucursal::findOne($idSucursal);
  $listaProductos = Producto::findMany();
  $productos = [];
  $inventarioFiltrado = [];

  foreach($listaProductos as $producto) {
    $productos[$producto->id] = $producto->nombre;
  }

  foreach($inventario as $elemento) {
    if ($elemento->idSucursal == $idSucursal) {
      $inventarioFiltrado[] = $elemento;
    }
  }
  $inventario = $inventarioFiltrado;

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var($_POST["idRegistro"], FILTER_VALIDATE_INT);

    if ($id) {
      $inventario = Inventario::findOne($id);
      $resultado = $inventario->delete();

      if ($resultado) {
        header('Location: ' . url_for('sucursales/inventario', $idSucursal));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/sucursales/inventario");
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Inventario de Sucursal</h1>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <a href="<?php echo url_for('sucursales/inventario/crear', $idSucursal); ?>">
          <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Añadir Existencias
          </button>
        </a>
      </div>
    </div>

    <p>Lista de productos disponible en la sucursal seleccionada.</p>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Dirección</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Producto</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($inventarioFiltrado as $row): ?>
        <tr>
          <th scope="row"><?php echo $row->id; ?></th>
          <td><?php echo $sucursal->direccion; ?></td>
          <td><?php echo $row->cantidad; ?></td>
          <td><?php echo $productos[$row->idProducto]; ?></td>
          <td>
            <div class="btn-group" role="group" aria-label="Acciones del Inventario">

              <a class="me-2" href="<?php echo url_for('sucursales/inventario/editar', $row->id); ?>">
                <button type="button" class="btn btn-info">
                  <i class="bi bi-pencil-fill"></i>
                </button>
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

  <a href="<?php echo url_for('sucursales'); ?>">
    <button type="button" class="btn btn-secondary">Regresar</button>
  </a>
</section>



<?php incluirTemplate('footer'); ?>