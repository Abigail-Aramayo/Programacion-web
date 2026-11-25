<?php
/**
 * admin/consultas.php  -  READ de las consultas guardadas desde contacto.php
 */
$ruta_base          = '../';
$titulo_pagina      = 'Consultas recibidas';
$menu_activo        = 'contacto.php';

require_once __DIR__ . '/../config/conexion.php';

$consultas = $pdo->query('SELECT id, nombre, apellido, email, motivo, mensaje, created_at FROM consultas ORDER BY id DESC')->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>
  <main>
    <section class="admin k-container">
      <span class="eyebrow">Administración</span>
      <h1 class="h-xl">Consultas <em>recibidas.</em></h1>
      <div class="admin__barra">
        <a href="index.php" class="btn-link">← Volver a productos</a>
        <span class="admin__total"><?= count($consultas) ?> consulta(s)</span>
      </div>
      <div class="tabla-wrap">
        <table class="tabla-admin">
          <thead><tr><th>ID</th><th>Fecha</th><th>Nombre</th><th>Email</th><th>Motivo</th><th>Mensaje</th></tr></thead>
          <tbody>
            <?php if (empty($consultas)): ?>
            <tr><td colspan="6">Todavía no hay consultas.</td></tr>
            <?php endif; ?>
            <?php foreach ($consultas as $c): ?>
            <tr>
              <td><?= e((string) $c['id']) ?></td>
              <td><?= e((string) $c['created_at']) ?></td>
              <td><?= e($c['nombre'] . ' ' . $c['apellido']) ?></td>
              <td><?= e($c['email']) ?></td>
              <td><?= e($c['motivo']) ?></td>
              <td><?= e($c['mensaje']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
