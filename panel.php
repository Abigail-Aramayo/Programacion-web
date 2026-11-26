<?php
/**
 * panel.php  -  PANEL DEL USUARIO (página protegida, TP8)
 * Cualquier usuario con sesión iniciada puede entrar.
 */
$titulo_pagina = 'Mi cuenta';
$menu_activo   = 'login.php';

require_once __DIR__ . '/includes/auth_guard.php';   // sin sesión -> login.php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/includes/formularios.php';

$aviso = (($_GET['error'] ?? '') === 'sin_permiso') ? 'No tenés permisos para acceder a esa sección.' : '';

// Datos del usuario logueado (consulta preparada con el id de la sesión)
$stmt = $pdo->prepare('SELECT nombre, email, created_at FROM usuarios WHERE id = :id');
$stmt->execute([':id' => $_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="panel k-container">
      <span class="eyebrow">Mi cuenta</span>
      <h1 class="h-xl">Hola, <?= e($_SESSION['usuario_nombre']) ?></h1>
      <?php if ($aviso): ?><p class="mensaje-error" role="alert"><?= e($aviso) ?></p><?php endif; ?>

      <dl class="panel__datos">
        <dt>Correo</dt><dd><?= e($usuario['email'] ?? '') ?></dd>
        <dt>Rol</dt><dd><?= e($_SESSION['rol']) ?></dd>
        <dt>Cliente desde</dt><dd><?= e(substr((string) ($usuario['created_at'] ?? ''), 0, 10)) ?></dd>
      </dl>

      <div class="panel__acciones">
        <a class="btn-kora btn-kora--sm" href="turnos.php">Agendar turno <i class="bi bi-arrow-right"></i></a>
        <a class="btn-mini" href="boutique.php">Ir a la boutique</a>
        <?php if ($_SESSION['rol'] === 'admin'): ?><a class="btn-mini" href="admin_panel.php">Panel de administración</a><?php endif; ?>
        <a class="btn-mini btn-mini--peligro" href="logout.php">Cerrar sesión</a>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
