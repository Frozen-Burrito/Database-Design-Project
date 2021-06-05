<div class="form-floating mb-3">
  <input 
    type="text" 
    name="tipo[nombre]" 
    class="form-control" 
    id="floatingNombre" 
    placeholder="" 
    value="<?php echo $tipo->nombre; ?>">
  <label for="floatingNombre">Nombre</label>
</div>

<div class="mb-3">
  <select id="selectCategoria" class="form-select" name="tipo[categoria]">
    <option value="">Selecciona una Categoría</option>
    <?php for($i = 0; $i < count($categorias); $i++) : ?>
        <option 
          <?php echo $tipo->categoria == $i ? 'selected' : ''; ?> 
          value="<?php echo $i; ?>"
        >
          <?php echo $categorias[$i]; ?>
        </option>
    <?php endfor; ?>
  </select>
</div>
