<?php 
  require '../../includes/app.php';

  use App\Producto;
  use App\Tipo;

  verificarLogin(2);

  $productos = Producto::findMany();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var($_POST["idRegistro"], FILTER_VALIDATE_INT);

    if ($id) {
      $producto = Producto::findOne($id);
      $resultado = $producto->delete();

      if ($resultado) {
        header('Location: ' . url_for('productos'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/productos");
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Productos</h1>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <a href="<?php echo url_for('productos/crear'); ?>">
          <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Nuevo Producto
          </button>
        </a>
      </div>
    </div>

    <p>Un Producto representa un artículo a la venta. Pueden realizarse ordenes e inventarios con él.</p>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Precio</th>
        <th scope="col">Descripción</th>
        <th scope="col">Tipo</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $row): ?>
        <tr>
          <th scope="row"><?php echo $row->id; ?></th>
          <td><?php echo $row->nombre; ?></td>
          <td><?php echo $row->precio; ?></td>
          <td><?php echo $row->descripcion; ?></td>
          <td><?php echo $row->idTipo; ?></td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <a class="me-2" href="<?php echo url_for('productos/editar', $row->id); ?>">
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