<?php 
  require 'includes/app.php';

  use App\Producto;

  verificarLogin();

  $productos = Producto::findMany();
  $rowCount = ceil(count($productos) / 3);
  
  incluirTemplate('header', $ruta = 'tienda');
?>
<section class="py-5 container">
  <div class="container mb-5">
    <div class="row justify-content-between">
      <div class="col-4">
        <h1 class="mb-4">Tienda</h1>
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

    <p>Nuestra amplia selección de productos se adapta a tus necesidades. Crea órdenes con unos clicks.</p>
  </div>
</section>
<section class="py-5 container">
  <div class="container-md">
    <?php for ($i = 0; $i < $rowCount; $i++) : ?>
      <div class="row mb-5">

      <?php for ($j = ($i * 3); $j < ($i * 3) + 3; $j++) : ?>
        <?php if ($j < count($productos) && !is_null($productos[$j])) : ?>
          <div class="col-4">
            <div class="card" style="width: 20rem;">
              <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.2KdMLsskO-By1dqK2epgegHaHa%26pid%3DApi&f=1" class="card-img-top" alt="Imagen de relleno">
              <div class="card-body">
                <h4 class="card-title"><?php echo $productos[$j]->nombre; ?></h4>
                <h5 class="text-info">$<?php echo $productos[$j]->precio; ?></h5>
                <p class="card-text"><?php echo $productos[$j]->descripcion; ?></p>
                <a href="<?php echo url_for('ordenes/crear', $productos[$j]->id); ?>" class="btn btn-primary">Ordenar</a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endfor; ?>
      </div>
    <?php endfor; ?>
  </div>
</section>
<?php incluirTemplate('footer'); ?>