<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
  <a href="<?= site_url('catalogo') ?>" class="volver">← Volver al catálogo</a>

  <article class="detalle">
    <div class="detalle__img">
      <?php if (! empty($producto['imagen'])): ?>
        <img src="<?= base_url('img/' . rawurlencode($producto['imagen'])) ?>" alt="<?= esc($producto['nombre'], 'attr') ?>" onerror="this.remove()">
      <?php endif; ?>
    </div>
    <div>
      <span class="tarjeta__cat"><?= esc($producto['categoria']) ?></span>
      <h1><?= esc($producto['nombre']) ?></h1>
      <p><?= esc($producto['descripcion']) ?></p>
      <p class="precio">$<?= number_format((float) $producto['precio'], 0, ',', '.') ?></p>
      <p class="stock"><?= (int) $producto['stock'] > 0 ? 'Stock disponible: ' . (int) $producto['stock'] : 'Sin stock' ?></p>
      <p><a class="btn-json" href="<?= site_url('api/productos/' . (int) $producto['id']) ?>">Ver este producto en JSON</a></p>
    </div>
  </article>
<?= $this->endSection() ?>
