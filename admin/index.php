<?php
/**
 * admin/index.php  -  READ (listado de productos)
 * TP7: lectura con PDO, integrada al layout del sitio.
 */
$ruta_base          = '../';
$titulo_pagina      = 'Administración de productos';
$descripcion_pagina = 'Gestión de productos de la boutique.';
$menu_activo        = 'boutique.php';

$rol_requerido      = 'admin';   // TP8: solo administradores
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';

// Mensajes que llegan por la URL (?status=...). Solo se aceptan estos valores.
$mensajes = [
    'created'    => ['ok',    'Producto creado correctamente.'],
    'updated'    => ['ok',    'Producto actualizado correctamente.'],
    'deleted'    => ['ok',    'Producto eliminado correctamente.'],
    'notfound'   => ['error', 'El producto solicitado no existe.'],
    'inuse'      => ['error', 'No se puede eliminar: el producto figura en pedidos. Desactivalo desde "Editar".'],
    'badrequest' => ['error', 'Solicitud inválida.'],
];
$status  = $_GET['status'] ?? '';
$mensaje = (is_string($status) && isset($mensajes[$status])) ? $mensajes[$status] : null;

// Lectura (la consulta no recibe datos del usuario; igual se usa JOIN para mostrar la categoría)
$stmt = $pdo->query(
    'SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, p.activo, c.nombre AS categoria
     FROM productos p
     INNER JOIN categorias c ON c.id = p.categoria_id
     ORDER BY p.id DESC'
);
$registros = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
