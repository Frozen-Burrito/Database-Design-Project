<div class="form-floating mb-3">
  <input 
    type="text" 
    name="cuenta[nombre]" 
    class="form-control" 
    id="floatingNombre" 
    placeholder="" 
    value="<?php echo $cuenta->nombre; ?>">
  <label for="floatingNombre">Nombre</label>
</div>
<div class="form-floating mb-3">
  <input 
    type="text" 
    name="cuenta[apellido]" 
    class="form-control" 
    id="floatingApellido" 
    placeholder="" 
    value="<?php echo $cuenta->apellido; ?>">

  <label for="floatingApellido">Apellido</label>
</div>

<?php if($cuenta instanceof App\Cliente) : ?>
  <div class="form-floating mb-3">
    <input 
      type="text" 
      name="cuenta[direccion]" 
      class="form-control" 
      id="floatingDireccion" 
      placeholder="" 
      value="<?php echo $cuenta->direccion; ?>">

    <label for="floatingDireccion">Dirección</label>
  </div>
<?php elseif ($cuenta instanceof App\Empleado && !isset($pagCuenta)): ?>
<div class="form-floating mb-3">
  <input 
    type="number" 
    name="cuenta[nomina]" 
    class="form-control" 
    id="floatingNomina" 
    placeholder="" 
    value="<?php echo $cuenta->nomina; ?>"
    min="0"
    max="10000">

  <label for="floatingNomina">Número de Nómina</label>
</div>
<div class="form-floating mb-3">
  <input 
    type="number" 
    name="cuenta[sueldo]" 
    class="form-control" 
    id="floatingSueldo" 
    placeholder="" 
    value="<?php echo $cuenta->sueldo; ?>"
    min="0"
    max="1000000">

  <label for="floatingSueldo">Sueldo Mensual</label>
</div>
<div>
  <label for="selectSucursal" class="form-label">Sucursal</label>
  <select id="selectSucursal" class="form-select" name="cuenta[idSucursal]">
    <option value="">Selecciona una Sucursal</option>
    <?php foreach($sucursales as $sucursal) : ?>
        <option 
          <?php echo $cuenta->idSucursal === $sucursal->id ? 'selected' : ''; ?> 
          value="<?php echo $sucursal->id; ?>"
        >
          <?php echo $sucursal->direccion; ?>
        </option>
    <?php endforeach; ?>
  </select>
</div>
<?php endif; ?>
