<?php 
  require '../../includes/app.php';

  use App\Tipo;

  verificarLogin(3);

  $tipos = Tipo::findMany();
  $categorias = Tipo::$categorias;

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var($_POST["idRegistro"], FILTER_VALIDATE_INT);

      if ($id) {
        $tipo = Tipo::findOne($id);
        $resultado = $tipo->delete();

        if ($resultado) {
          header('Location: ' . url_for('tipos'));
        }
      }
  }

  incluirTemplate('header', $ruta = 'crud/tipos');
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Tipos</h1>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <a href="<?php echo url_for('tipos/crear'); ?>">
          <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Nuevo Tipo
          </button>
        </a>
      </div>
    </div>

    <p>Un Tipo clasifica a otras entidades como Productos, Usuarios o Empleados.</p>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Categoría</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tipos as $row): ?>
        <tr>
          <th scope="row"><?php echo $row->id; ?></th>
          <td><?php echo $row->nombre; ?></td>
          <td><?php echo $categorias[$row->categoria]; ?></td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <a class="me-2" href="<?php echo url_for('tipos/editar', $row->id); ?>">
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