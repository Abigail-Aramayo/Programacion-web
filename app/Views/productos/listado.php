<?php
/**
 * VISTA: listado de productos. Solo HTML + datos que le pasa el controlador.
 * Variables: $registros (array), $mensaje (null | [tipo, texto])
 */
?>
  <main>
    <section class="admin k-container">
      <span class="eyebrow">Administración</span>
      <h1 class="h-xl">Productos de la <em>boutique.</em></h1>

      <?php if ($mensaje): ?>
      <p class="<?= $mensaje[0] === 'ok' ? 'mensaje-ok' : 'mensaje-error' ?>" role="status"><?= e($mensaje[1]) ?></p>
      <?php endif; ?>

      <div class="admin__barra">
        <a href="crear.php" class="btn-kora">Agregar producto <i class="bi bi-plus-lg"></i></a>
        <a href="consultas.php" class="btn-link">Ver consultas recibidas</a>
        <span class="admin__total"><?= count($registros) ?> producto(s)</span>
      </div>

      <div class="tabla-wrap">
        <table class="tabla-admin">
          <thead>
            <tr><th>ID</th><th>Nombre</th><th>Categoría</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
          </thead>
          <tbody>
            <?php if (empty($registros)): ?>
            <tr><td colspan="8">Todavía no hay productos cargados.</td></tr>
            <?php endif; ?>
            <?php foreach ($registros as $item): ?>
            <tr>
              <td><?= e((string) $item['id']) ?></td>
              <td><?= e($item['nombre']) ?></td>
              <td><?= e($item['categoria']) ?></td>
              <td><?= e($item['descripcion']) ?></td>
              <td>$<?= e(number_format((float) $item['precio'], 2, ',', '.')) ?></td>
              <td><?= e((string) $item['stock']) ?></td>
              <td><?= $item['activo'] ? 'Activo' : 'Inactivo' ?></td>
              <td class="tabla-admin__acciones">
                <a href="editar.php?id=<?= (int) $item['id'] ?>" class="btn-mini">Editar</a>
                <!-- El borrado se envía por POST (un link GET podría ejecutarse sin querer) -->
                <form method="post" action="eliminar.php" onsubmit="return confirm('¿Confirma eliminar este producto?')">
                  <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                  <button type="submit" class="btn-mini btn-mini--peligro">Eliminar</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
