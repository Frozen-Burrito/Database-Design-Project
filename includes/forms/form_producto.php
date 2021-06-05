<div class="form-floating mb-3">
  <input 
    type="text" 
    name="producto[nombre]" 
    class="form-control" 
    id="floatingNombre" 
    placeholder="" 
    value="<?php echo $producto->nombre; ?>">
  <label for="floatingNombre">Nombre</label>
</div>
<div class="form-floating mb-3">
  <input 
    type="number" 
    name="producto[precio]" 
    class="form-control" 
    id="floatingCategoria" 
    placeholder="" 
    value="<?php echo $producto->precio; ?>"
    min="0"
    max="1000000">

  <label for="floatingCategoria">Precio</label>
</div>
<div class="mb-3">
  <label for="textDescripcion" class="form-label">Descripción</label>
  <textarea class="form-control" id="textDescripcion" name="producto[descripcion]" rows="3"><?php echo $producto->descripcion; ?></textarea>
</div>
<div class="mb-3">
  <label for="selectTipo" class="form-label">Tipo</label>
  <select id="selectTipo" class="form-select" name="producto[idTipo]">
    <option value="">Selecciona un Tipo</option>
    <?php foreach($tipos as $tipo) : ?>
        <option 
          <?php echo $producto->idTipo === $tipo->id ? 'selected' : ''; ?> 
          value="<?php echo $tipo->id; ?>"
        >
          <?php echo $tipo->nombre; ?>
        </option>
    <?php endforeach; ?>
  </select>
</div>
