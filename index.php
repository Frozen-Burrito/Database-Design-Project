<?php 
  require 'includes/app.php';

  verificarLogin();
  
  incluirTemplate('header', $ruta = 'inicio');
?>
<section class="py-5 text-center container">
  <h1>Hola Mundo</h1>

  <a href="<?php echo url_for('tienda'); ?>">
    <button type="button" class="btn btn-primary">Ver Productos</button>
  </a>
</section class="py-5 container">
<?php incluirTemplate('footer'); ?>