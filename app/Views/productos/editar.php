<?php /** VISTA: modificación de producto. Variables: $id, $datos, $errores, $categorias, $accion, $texto_boton */ ?>
  <main>
    <section class="admin k-container">
      <span class="eyebrow">Administración</span>
      <h1 class="h-xl">Editar <em>producto #<?= (int) $id ?>.</em></h1>
      <?php require __DIR__ . '/_formulario.php'; ?>
    </section>
  </main>
