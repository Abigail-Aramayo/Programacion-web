<?php
/**
 * admin/eliminar.php  -  DELETE (baja de producto)
 * Solo acepta POST. No muestra HTML: ejecuta el DELETE y redirige.
 */
$ruta_base     = '../';
$rol_requerido = 'admin';   // TP8: solo administradores
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?status=badrequest');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    header('Location: index.php?status=badrequest');
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM productos WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $estado = ($stmt->rowCount() > 0) ? 'deleted' : 'notfound';
} catch (PDOException $ex) {
    // 23000 = violación de clave foránea (el producto está en detalle_pedidos)
    $estado = ($ex->getCode() === '23000') ? 'inuse' : 'badrequest';
    error_log('eliminar.php: ' . $ex->getMessage());
}

header('Location: index.php?status=' . $estado);
exit;
