<?php 
  require '../../includes/app.php';

  use App\Usuario;
  use App\Cliente;
  use App\Empleado;
  use App\Tipo;

  verificarLogin(3);

  $usuarios = Usuario::findMany();
  $tipos = Tipo::findMany();

  $tiposPorId = [];
  foreach($tipos as $tipo) {
    $tiposPorId[$tipo->id] = $tipo->nombre;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_var($_POST["idRegistro"], FILTER_VALIDATE_INT);

    if ($id) {
      $usuario = Usuario::findOne($id);
      $cuenta = $usuario->idTipo > 8 && $usuario->idTipo < 12 
        ? Empleado::findWhere('idUsuario', $usuario->id)
        : Cliente::findWhere('idUsuario', $usuario->id);

      $resultadoCuenta = $cuenta->delete();
      $resultado = $usuario->delete();

      if ($resultado && $resultadoCuenta) {
        header('Location: ' . url_for('usuarios'));
      }
    }
  }

  incluirTemplate('header', $ruta = "crud/usuarios");
?>

<section class="py-5 container">

  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Usuarios</h1>
      </div>
      <div class="col-4 d-flex justify-content-end">
        <a href="<?php echo url_for('usuarios/crear', 0); ?>">
          <button type="button" class="btn btn-info">
            <i class="bi bi-plus-lg"></i>
            Nuevo Cliente
          </button>
        </a>
        <a class="ms-3" href="<?php echo url_for('usuarios/crear', 1); ?>">
          <button type="button" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Nuevo Empleado
          </button>
        </a>
      </div>
    </div>

    <p>Un usuario contiene las credenciales usadas para interactuar con el sistema.</p>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre de Usuario</th>
        <th scope="col">Correo Electrónico</th>
        <th scope="col">Contraseña</th>
        <th scope="col">Tipo</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $row): ?>
        <?php $usuarioActual = $row->username == $_SESSION['usuario']; ?>
        <tr>
          <th scope="row"><?php echo $row->id; ?></th>
          <td class="<?php echo $usuarioActual ? 'text-primary' : ''; ?>">
            <?php if($usuarioActual) : ?>
              <i class="bi bi-person-fill"></i>
            <?php endif; ?>
            <?php echo $row->username; ?>
          </td>
          <td><?php echo $row->email; ?></td>
          <td><?php echo $row->password; ?></td>
          <td><?php echo $tiposPorId[$row->idTipo]; ?></td>
          <td>
            <div class="btn-group" role="group" aria-label="Basic example">
              <a class="me-2" href="<?php echo url_for('usuarios/editar', $row->id); ?>">
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