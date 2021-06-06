<?php 
  require 'includes/app.php';

  verificarLogin();
  
  incluirTemplate('header', $ruta = 'inicio');
?>
<section class="py-5 text-center container">
  <h1>Proyecto Final: CRUD</h1>

  <a href="<?php echo url_for('tienda'); ?>">
    <button type="button" class="btn btn-primary">Ver Productos</button>
  </a>

  <div class="card mt-5 center-all" style="max-width: 40rem; margin: auto;">
      <div class="card-body">
        <h1 class="my-3">Cómo Usar Este Sitio</h1>

        <ol style="text-align: left;">
          <li>Inicia sesión para poder realizar operaciones CRUD.</li>
          <li>En el menú "Recursos" podrás acceder a casi todas las entidades.</li>
          <li>En el ícono de cuenta, puedes ver aspectos relacionados con tu cuenta o cerrar sesión.</li>
        </ol>
    </div>
  </div>

  <div class="card mt-5 center-all" style="max-width: 40rem; margin: auto;">
      <div class="card-body">
        <h1 class="mt-2">Datos</h1>

        <h3 class="my-3">6G1 - Bases de Datos II</h3>

        <ol style="text-align: left;">
          <li>Donnet Hazael Pitalua Santana - 18300356</li>
          <li>Fernando Mendoza Velasco - 18300290</li>
        </ol>
    </div>
  </div>
</section class="py-5 container">
<?php incluirTemplate('footer'); ?>