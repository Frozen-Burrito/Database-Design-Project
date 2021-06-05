<div class="form-floating mb-3">
  <input 
    type="text" 
    name="usuario[username]" 
    class="form-control" 
    id="floatingUsername" 
    placeholder="" 
    value="<?php echo $usuario->username; ?>">
  <label for="floatingUsername">Nombre de Usuario</label>
</div>
<div class="form-floating mb-3">
  <input 
    type="text" 
    name="usuario[email]" 
    class="form-control" 
    id="floatingEmail" 
    placeholder="" 
    value="<?php echo $usuario->email; ?>">

  <label for="floatingEmail">Correo Electrónico</label>
</div>
<div class="form-floating mb-3">
  <input 
    type="password" 
    name="usuario[password]" 
    class="form-control" 
    id="floatingPassword" 
    placeholder="" 
    value="<?php echo strlen($usuario->password) < 20 ? $usuario->password : ''; ?>">

  <label for="floatingPassword">Contraseña</label>
</div>
<div class="mb-3">
  <label for="selectTipo" class="form-label">Tipo de Usuario</label>
  <select id="selectTipo" class="form-select" name="usuario[idTipo]">
    <option value="">Selecciona un Tipo</option>
    <?php foreach($tipos as $tipo) : ?>
      <?php if (isset($cuenta)) : ?>
        <?php if($cuenta instanceof App\Cliente) : ?>
          <?php if ($tipo->id == 8) :?>
            <option 
              <?php echo $usuario->idTipo === $tipo->id ? 'selected' : ''; ?> 
              value="<?php echo $tipo->id; ?>"
            >
              <?php echo $tipo->nombre; ?>
            </option>
          <?php endif; ?>
        <?php elseif ($cuenta instanceof App\Empleado): ?>
          <?php if ($tipo->id > 8 && $tipo->id < 12) :?>
            <option 
              <?php echo $usuario->idTipo === $tipo->id ? 'selected' : ''; ?> 
              value="<?php echo $tipo->id; ?>"
            >
              <?php echo $tipo->nombre; ?>
            </option>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    
    <?php endforeach; ?>
  </select>
</div>
