<?php
/**
 * admin/crear.php  -  CREATE (alta de producto)
 * Formulario + INSERT con consulta preparada.
 */
$ruta_base          = '../';
$titulo_pagina      = 'Nuevo producto';
$menu_activo        = 'boutique.php';

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/_validar.php';

$categorias = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre')->fetchAll();
$errores    = [];
$datos      = ['nombre' => '', 'categoria_id' => '', 'descripcion' => '', 'precio' => '', 'stock' => '0', 'imagen' => '', 'activo' => 1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$datos, $errores] = validar_producto($pdo);

    if (empty($errores)) {
        try {
            // Consulta preparada: los datos NUNCA se concatenan al SQL (anti SQL Injection)
            $sql  = 'INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, imagen, activo)
                     VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :imagen, :activo)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':categoria_id' => (int) $datos['categoria_id'],
                ':nombre'       => $datos['nombre'],
                ':descripcion'  => $datos['descripcion'],
                ':precio'       => (float) $datos['precio'],
                ':stock'        => (int) $datos['stock'],
                ':imagen'       => $datos['imagen'] !== '' ? $datos['imagen'] : null,
                ':activo'       => (int) $datos['activo'],
            ]);
            header('Location: index.php?status=created');
            exit;
        } catch (PDOException $ex) {
            error_log('crear.php: ' . $ex->getMessage());
            $errores['general'] = 'No se pudo guardar el producto. Intentá nuevamente.';
        }
    }
}

$accion       = 'crear.php';
$texto_boton  = 'Guardar producto';
require_once __DIR__ . '/../includes/header.php';
?>
  <main>
    <section class="admin k-container">
      <span class="eyebrow">Administración</span>
      <h1 class="h-xl">Nuevo <em>producto.</em></h1>
      <?php if (!empty($errores)): ?>
      <div class="mensaje-error" role="alert">
        <strong>Revisá estos datos antes de guardar:</strong>
        <ul><?php foreach ($errores as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
      </div>
      <?php endif; ?>
      <?php require __DIR__ . '/_form.php'; ?>
    </section>
  </main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
