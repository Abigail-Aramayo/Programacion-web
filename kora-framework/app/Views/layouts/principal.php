<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($titulo ?? 'Catálogo') ?> | Kora Hair</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/catalogo.css') ?>">
</head>
<body>
  <header class="cabecera">
    <a class="marca" href="<?= site_url('catalogo') ?>"><span>KORA</span><small>HAIR · MÓDULO CON FRAMEWORK</small></a>
    <nav>
      <a href="<?= site_url('catalogo') ?>">Catálogo</a>
      <a href="<?= site_url('api/productos') ?>">API JSON</a>
    </nav>
  </header>

  <?php /* La vista hija se inserta acá */ ?>
  <main class="contenedor">
    <?= $this->renderSection('contenido') ?>
  </main>

  <footer class="pie">Kora Hair · Salta · TP10 – Módulo desarrollado con CodeIgniter 4</footer>
</body>
</html>
