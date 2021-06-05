<?php 
  $autenticado = isset($_SESSION['nivel']) 
    ? $_SESSION['nivel'] > 0
    : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  
  <link href="/8_crud/src/css/index.css" rel="stylesheet">

  <title>Sistema CRUD</title>
</head>
<body class="<?php echo $navegacion ? '' : 'center'; ?>">

<?php if ($navegacion) : ?>
<!-- Navegacion -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-md m-auto row justify-content-between">
      <div class="col-4">
        <a class="navbar-brand mb-0 h1" href="<?php echo url_for('inicio'); ?>">CRUD</a>
      </div>

      <div class="col-4 d-flex justify-content-end">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php echo $ruta == 'inicio' ? 'active' : ''; ?>" href="<?php echo url_for('inicio'); ?>">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $ruta == 'tienda' ? 'active' : ''; ?>" href="<?php echo url_for('tienda'); ?>">Tienda</a>
            </li>

            <?php if($autenticado) : ?>
              <?php if($_SESSION['nivel'] > 1) : ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Recursos
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="<?php echo url_for('productos'); ?>">Productos</a></li>
                    <li><a class="dropdown-item" href="<?php echo url_for('tipos'); ?>">Tipos</a></li>
                    <li><a class="dropdown-item" href="<?php echo url_for('sucursales'); ?>">Sucursales</a></li>
                    <li><a class="dropdown-item" href="<?php echo url_for('ordenes'); ?>">Órdenes</a></li>
                    <li><a class="dropdown-item" href="<?php echo url_for('usuarios'); ?>">Usuarios</a></li>
                  </ul>
                </li>
              <?php endif; ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="accountDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="accountDropdownLink">
                  <li><a class="dropdown-item" href="<?php echo url_for('cuenta'); ?>">Cuenta</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('ordenes'); ?>">Mis Órdenes</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('logout'); ?>">Cerrar Sesión</a></li>
                </ul>
              </li>
              
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link <?php echo $ruta == 'login' ? 'active' : ''; ?>" href="<?php echo url_for('login'); ?>">Inicia Sesión</a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url_for('clientes/crear'); ?>">
                  <button type="button" class="btn btn-primary">Crear Cuenta</button>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
  </div>
</nav>

<?php endif; ?>