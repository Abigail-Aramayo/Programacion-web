<?php
/**
 * admin/editar.php  -  UPDATE (modificación de producto)
 * Se carga el registro con SELECT preparado y se actualiza con UPDATE preparado.
 */
$ruta_base          = '../';
$titulo_pagina      = 'Editar producto';
$menu_activo        = 'boutique.php';

$rol_requerido      = 'admin';   // TP8: solo administradores
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/_validar.php';

// El id siempre viaja en la URL (editar.php?id=3), tanto al abrir como al guardar
// (el formulario hace POST a editar.php?id=3). Debe ser un entero válido.
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    header('Location: index.php?status=badrequest');
    exit;
}

// Buscar el producto (consulta preparada)
$stmt = $pdo->prepare('SELECT * FROM productos WHERE id = :id');
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch();
if (!$producto) {
    header('Location: index.php?status=notfound');
    exit;
}

$categorias = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre')->fetchAll();
$errores    = [];
$datos      = [
    'nombre'       => (string) $producto['nombre'],
    'categoria_id' => (string) $producto['categoria_id'],
    'descripcion'  => (string) $producto['descripcion'],
    'precio'       => (string) $producto['precio'],
    'stock'        => (string) $producto['stock'],
    'imagen'       => (string) $producto['imagen'],
    'activo'       => (int) $producto['activo'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$datos, $errores] = validar_producto($pdo);

    if (empty($errores)) {
        try {
            $sql  = 'UPDATE productos
                     SET categoria_id = :categoria_id, nombre = :nombre, descripcion = :descripcion,
                         precio = :precio, stock = :stock, imagen = :imagen, activo = :activo
                     WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':categoria_id' => (int) $datos['categoria_id'],
                ':nombre'       => $datos['nombre'],
                ':descripcion'  => $datos['descripcion'],
                ':precio'       => (float) $datos['precio'],
                ':stock'        => (int) $datos['stock'],
                ':imagen'       => $datos['imagen'] !== '' ? $datos['imagen'] : null,
                ':activo'       => (int) $datos['activo'],
                ':id'           => $id,
            ]);
            header('Location: index.php?status=updated');
            exit;
        } catch (PDOException $ex) {
            error_log('editar.php: ' . $ex->getMessage());
            $errores['general'] = 'No se pudo actualizar el producto. Intentá nuevamente.';
        }
    }
}

$accion       = 'editar.php?id=' . $id;
$texto_boton  = 'Guardar cambios';
require_once __DIR__ . '/../includes/header.php';
?>
  <main>
    <section class="admin k-container">
      <span class="eyebrow">Administración</span>
      <h1 class="h-xl">Editar <em>producto #<?= (int) $id ?>.</em></h1>
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
