<?php
$menu = [
    'index.php'     => 'Inicio',
    'sobre-mi.php'  => 'Sobre mí',
    'servicios.php' => 'Servicios',
    'boutique.php'  => 'Boutique',
    'test.php'      => 'Tu Brújula Capilar',
    'contacto.php'  => 'Contacto',
];

$pagina_actual = $menu_activo ?? basename($_SERVER['SCRIPT_NAME']);
?>
  <?php if ($mostrar_topbar ?? true): ?>
  <div class="topbar">Envíos gratis desde $85.000 <span class="dot">•</span> Tu primer diagnóstico capilar es sin cargo</div>
  <?php endif; ?>

  <header class="site-header">
    <nav class="navbar navbar-expand-lg k-container" aria-label="Navegación principal">
      <a class="brand" href="index.php" aria-label="<?= e(APP_NAME) ?>, inicio">
        <span class="brand__name">KORA</span>
        <span class="brand__sub">HAIR · TU BRÚJULA CAPILAR</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav menu-principal">
          <?php foreach ($menu as $archivo => $texto): ?>
            <?php $activo = ($archivo === $pagina_actual); ?>
          <li class="nav-item">
            <a class="nav-link<?= $activo ? ' active' : '' ?>" href="<?= $archivo ?>"<?= $activo ? ' aria-current="page"' : '' ?>><?= $texto ?></a>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="acciones">
          <a href="login.php" class="icono-btn" aria-label="Mi cuenta"><i class="bi bi-person"></i></a>
          <a href="carrito.php" class="icono-btn" aria-label="Carrito"><i class="bi bi-bag"></i><span class="badge-k" data-carrito-badge>1</span></a>
          <a href="turnos.php" class="btn-kora btn-kora--sm">Agendar turno <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </nav>
  </header>
