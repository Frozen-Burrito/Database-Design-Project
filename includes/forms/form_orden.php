<div class="mb-3">
  <label for="selectProducto" class="form-label">Producto</label>
  <select id="selectProducto" class="form-select" name="orden[idProducto]">
    <option value="">Selecciona un Producto</option>
    <?php foreach($productos as $producto) : ?>
        <option 
          <?php echo $orden->idProducto == $producto->id ? 'selected' : ''; ?> 
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
    name="orden[cantidad]" 
    class="form-control" 
    id="floatingCategoria" 
    placeholder="" 
    value="<?php echo $orden->cantidad; ?>"
    min="1"
    max="100">

  <label for="floatingCategoria">Cantidad</label>
</div>

<div class="form-floating mb-3">
  <input 
    type="date" 
    name="orden[fechaEntrega]" 
    class="form-control" 
    id="floatingFechaEntrega" 
    value="<?php echo $orden->fechaEntrega; ?>">
  <label for="floatingFechaEntrega">Fecha de Entrega</label>
</div>