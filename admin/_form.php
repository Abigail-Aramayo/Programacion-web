<?php
/**
 * admin/_form.php
 * Formulario compartido por crear.php y editar.php.
 * Espera: $datos (valores actuales), $errores, $categorias, $accion, $texto_boton
 */
?>
<form class="formulario formulario--admin" method="post" action="<?= e($accion) ?>" novalidate>
  <div>
    <label for="nombre">Nombre del producto</label>
    <input id="nombre" name="nombre" type="text" maxlength="100" value="<?= e($datos['nombre']) ?>"<?= isset($errores['nombre']) ? ' class="campo-error"' : '' ?>>
  </div>
  <div>
    <label for="categoria_id">Categoría</label>
    <select id="categoria_id" name="categoria_id"<?= isset($errores['categoria_id']) ? ' class="campo-error"' : '' ?>>
      <option value="">Elegí una categoría...</option>
      <?php foreach ($categorias as $cat): ?>
      <option value="<?= e((string) $cat['id']) ?>"<?= (string) $datos['categoria_id'] === (string) $cat['id'] ? ' selected' : '' ?>><?= e($cat['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" maxlength="500"><?= e($datos['descripcion']) ?></textarea>
  </div>
  <div class="fila-2">
    <div>
      <label for="precio">Precio ($)</label>
      <input id="precio" name="precio" type="text" inputmode="decimal" value="<?= e($datos['precio']) ?>"<?= isset($errores['precio']) ? ' class="campo-error"' : '' ?>>
    </div>
    <div>
      <label for="stock">Stock</label>
      <input id="stock" name="stock" type="text" inputmode="numeric" value="<?= e($datos['stock']) ?>"<?= isset($errores['stock']) ? ' class="campo-error"' : '' ?>>
    </div>
  </div>
  <div>
    <label for="imagen">Imagen (nombre del archivo en /img, opcional)</label>
    <input id="imagen" name="imagen" type="text" maxlength="200" placeholder="serum.jpg" value="<?= e($datos['imagen']) ?>"<?= isset($errores['imagen']) ? ' class="campo-error"' : '' ?>>
  </div>
  <div class="check">
    <label><input type="checkbox" name="activo" value="1"<?= !empty($datos['activo']) ? ' checked' : '' ?>> Producto activo (visible en la boutique)</label>
  </div>
  <div class="acciones-form">
    <button type="submit" class="btn-kora"><?= e($texto_boton) ?></button>
    <a href="index.php" class="btn-link">Cancelar</a>
  </div>
</form>
