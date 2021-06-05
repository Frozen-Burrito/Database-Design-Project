<div class="mb-3">
  <label for="selectProducto" class="form-label">Producto</label>
  <select id="selectProducto" class="form-select" name="inventario[idProducto]">
    <option value="">Selecciona un Prodcuto</option>
    <?php foreach($productos as $producto) : ?>
        <option 
          <?php echo $inventario->idProducto == $producto->id ? 'selected' : ''; ?> 
          value="<?php echo $producto->id; ?>"
        >
          <?php echo $producto->nombre; ?>
        </option>
    <?php endforeach; ?>
  </select>
</div>

<div class="form-floating mb-3">
  <input 
    type="number" 
    name="inventario[cantidad]" 
    class="form-control" 
    id="floatingInventario" 
    placeholder="" 
    value="<?php echo $inventario->cantidad; ?>"
    min="1"
    max="100">

  <label for="floatingInventario">Cantidad</label>
</div>

<div>
  <label for="selectSucursal" class="form-label">Sucursal</label>
  <select id="selectSucursal" class="form-select" name="inventario[idSucursal]">
    <option value="">Selecciona una Sucursal</option>
    <?php foreach($sucursales as $sucursal) : ?>
        <option 
          <?php echo $inventario->idSucursal == $sucursal->id ? 'selected' : ''; ?> 
          value="<?php echo $sucursal->id; ?>"
        >
          <?php echo $sucursal->direccion; ?>
        </option>
    <?php endforeach; ?>
  </select>
</div>