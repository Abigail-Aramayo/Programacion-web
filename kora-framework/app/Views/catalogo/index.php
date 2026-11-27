<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
  <span class="eyebrow">Catálogo</span>
  <h1>Productos de la <em>boutique.</em></h1>

  <!-- Reporte: datos calculados por el modelo con el Query Builder -->
  <div class="resumen">
    <div><strong><?= (int) $resumen['total'] ?></strong><span>Productos activos</span></div>
    <div><strong><?= (int) $resumen['stock_total'] ?></strong><span>Unidades en stock</span></div>
    <div><strong>$<?= number_format((float) $resumen['precio_promedio'], 0, ',', '.') ?></strong><span>Precio promedio</span></div>
  </div>

  <div class="filtros">
    <a href="<?= site_url('catalogo') ?>" class="chip<?= $categoriaId === null ? ' activo' : '' ?>">Todos</a>
    <?php foreach ($categorias as $cat): ?>
      <a href="<?= site_url('catalogo') . '?categoria=' . (int) $cat['id'] ?>" class="chip<?= $categoriaId === (int) $cat['id'] ? ' activo' : '' ?>"><?= esc($cat['nombre']) ?></a>
    <?php endforeach; ?>
  </div>

  <?php if (empty($productos)): ?>
    <p class="vacio">No hay productos para mostrar.</p>
  <?php else: ?>
  <div class="grilla">
    <?php foreach ($productos as $p): ?>
    <article class="tarjeta">
      <a href="<?= site_url('catalogo/' . (int) $p['id']) ?>" class="tarjeta__img">
        <?php if (! empty($p['imagen'])): ?>
          <img src="<?= base_url('img/' . rawurlencode($p['imagen'])) ?>" alt="<?= esc($p['nombre'], 'attr') ?>" loading="lazy" onerror="this.remove()">
        <?php endif; ?>
      </a>
      <span class="tarjeta__cat"><?= esc($p['categoria']) ?></span>
      <h2><a href="<?= site_url('catalogo/' . (int) $p['id']) ?>"><?= esc($p['nombre']) ?></a></h2>
      <p><?= esc($p['descripcion']) ?></p>
      <strong class="precio">$<?= number_format((float) $p['precio'], 0, ',', '.') ?></strong>
    </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
<?= $this->endSection() ?>
