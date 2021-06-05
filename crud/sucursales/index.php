<?php 
  require '../../includes/app.php';

  use App\Sucursal;

  verificarLogin(3);

  $sucursales = Sucursal::findMany();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var($_POST["idRegistro"], FILTER_VALIDATE_INT);

    if ($id) {
      $sucursal = Sucursal::findOne($id);
      $resultado = $sucursal->delete();

      if ($resultado) {
        header('Location: ' . url_for('sucursales'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/sucursales");
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Sucursales</h1>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <a href="<?php echo url_for('sucursales/crear'); ?>">
          <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Nueva Sucursal
          </button>
        </a>
      </div>
    </div>

    <p>Ubicaciones en las que existen tiendas físicas, con inventario y empleados.</p>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Dirección</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($sucursales as $row): ?>
        <tr>
          <th scope="row"><?php echo $row->id; ?></th>
          <td><?php echo $row->direccion; ?></td>
          <td>
            <div class="btn-group" role="group" aria-label="Acciones de la sucursal">
              <a class="me-2" href="<?php echo url_for('sucursales/inventario', $row->id); ?>">
                <button type="button" class="btn btn-success">
                  <i class="bi bi-box-seam"></i>
                  Inventario
                </button>
              </a>

              <a class="me-2" href="<?php echo url_for('sucursales/editar', $row->id); ?>">
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