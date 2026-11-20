<?php
/**
 * buscar.php  -  FORMULARIO POR GET (TP5)
 * --------------------------------------------------------------
 * Buscador del sitio. Los datos viajan en la URL:
 *     buscar.php?q=serum&categoria=productos
 * Una búsqueda no modifica nada en el servidor (es idempotente),
 * por eso corresponde GET. Además se puede copiar y compartir el link.
 */
$titulo_pagina      = 'Buscar';
$descripcion_pagina = 'Buscá servicios y productos de Kora Hair.';

require_once __DIR__ . '/config/env.php';
require_once __DIR__ . '/includes/formularios.php';

$catalogo = require __DIR__ . '/config/catalogo.php';

// Categorías permitidas (lista blanca)
$categorias = ['todos' => 'Todo', 'servicios' => 'Servicios', 'productos' => 'Productos'];

$errores    = [];
$resultados = [];
$buscado    = isset($_GET['q']);       // ¿se envió el formulario? (si no, solo se muestra el formulario)

// CAPTURAR + SANITIZAR
$q         = sanitizar_texto(capturar('GET', 'q'));
$categoria = capturar('GET', 'categoria');
if (!array_key_exists($categoria, $categorias)) {
    $categoria = 'todos';              // valor inválido -> se usa el valor por defecto
}

if ($buscado) {
    // VALIDAR
    if (empty($q)) {
        $errores[] = 'Escribí qué querés buscar.';
    } elseif (largo($q) < 2) {
        $errores[] = 'La búsqueda debe tener al menos 2 caracteres.';
    } elseif (largo($q) > 50) {
        $errores[] = 'La búsqueda no puede superar los 50 caracteres.';
    }

    // BUSCAR (solo si no hay errores)
    if (empty($errores)) {
        foreach ($catalogo as $item) {
            $coincideCategoria = ($categoria === 'todos' || $item['tipo'] === $categoria);
            $coincideTexto = mb_stripos($item['nombre'] . ' ' . $item['detalle'], $q, 0, 'UTF-8') !== false;
            if ($coincideCategoria && $coincideTexto) {
                $resultados[] = $item;
            }
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="buscador k-container">
      <span class="eyebrow">Buscador</span>
      <h1 class="h-xl">Encontrá tu <em>ritual ideal.</em></h1>

      <!-- method="get": los datos van en la URL -->
      <form class="buscador__form" method="get" action="buscar.php" novalidate>
        <div>
          <label for="q">¿Qué estás buscando?</label>
          <input id="q" name="q" type="search" placeholder="Ej: sérum, nutrición..." maxlength="50" value="<?= e($q) ?>"<?= !empty($errores) ? ' class="campo-error"' : '' ?>>
        </div>
        <div>
          <label for="categoria">Categoría</label>
          <select id="categoria" name="categoria">
            <?php foreach ($categorias as $clave => $texto): ?>
            <option value="<?= e($clave) ?>"<?= $categoria === $clave ? ' selected' : '' ?>><?= e($texto) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn-kora">Buscar <i class="bi bi-search"></i></button>
      </form>

      <?php if (!empty($errores)): ?>
      <div class="mensaje-error" role="alert">
        <strong>No pudimos realizar la búsqueda:</strong>
        <ul><?php foreach ($errores as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
      </div>
      <?php elseif ($buscado): ?>
      <p class="buscador__resumen" role="status">
        <?= count($resultados) ?> resultado(s) para «<strong><?= e($q) ?></strong>» en <?= e($categorias[$categoria]) ?>.
      </p>
        <?php if (empty($resultados)): ?>
        <p class="mensaje-info">No encontramos coincidencias. Probá con otra palabra.</p>
        <?php else: ?>
        <ul class="lista-busqueda">
          <?php foreach ($resultados as $r): ?>
          <li class="item-busqueda">
            <small><?= e(ucfirst($r['tipo'])) ?></small>
            <h3><a href="<?= e($r['url']) ?>"><?= e($r['nombre']) ?></a></h3>
            <p><?= e($r['detalle']) ?></p>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
