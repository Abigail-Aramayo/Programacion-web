<?php
/**
 * admin_panel.php  -  PANEL DE ADMINISTRACIÓN (solo rol "admin", TP8)
 */
$titulo_pagina = 'Panel de administración';
$menu_activo   = 'login.php';
$rol_requerido = 'admin';                             // solo administradores

require_once __DIR__ . '/includes/auth_guard.php';   // sin sesión -> login / otro rol -> panel.php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/includes/formularios.php';

// Resumen con consultas de solo lectura
$totales = [];
foreach (['productos' => 'productos', 'usuarios' => 'usuarios', 'consultas' => 'consultas'] as $etiqueta => $tabla) {
    $totales[$etiqueta] = (int) $pdo->query("SELECT COUNT(*) FROM {$tabla}")->fetchColumn();   // nombres fijos, sin input del usuario
}

require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="panel k-container">
      <span class="eyebrow">Administración</span>
      <h1 class="h-xl">Hola, <?= e($_SESSION['usuario_nombre']) ?></h1>

      <div class="panel__tarjetas">
        <?php foreach ($totales as $etiqueta => $n): ?>
        <div class="panel__tarjeta"><strong><?= $n ?></strong><span><?= e(ucfirst($etiqueta)) ?></span></div>
        <?php endforeach; ?>
      </div>

      <div class="panel__acciones">
        <a class="btn-kora btn-kora--sm" href="admin/index.php">Gestionar productos <i class="bi bi-arrow-right"></i></a>
        <a class="btn-mini" href="admin/consultas.php">Ver consultas</a>
        <a class="btn-mini" href="panel.php">Mi cuenta</a>
        <a class="btn-mini btn-mini--peligro" href="logout.php">Cerrar sesión</a>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
