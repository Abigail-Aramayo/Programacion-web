<?php
/**
 * admin/_validar.php
 * Captura, sanitiza y valida los datos del formulario de productos.
 * Devuelve [$datos, $errores]. Se usa en crear.php y editar.php.
 */
require_once __DIR__ . '/../includes/formularios.php';

function validar_producto(PDO $pdo): array
{
    $errores = [];

    // 1) Captura + sanitización (trim + quitar etiquetas HTML)
    $datos = [
        'nombre'       => sanitizar_texto(capturar('POST', 'nombre')),
        'categoria_id' => capturar('POST', 'categoria_id'),
        'descripcion'  => sanitizar_texto(capturar('POST', 'descripcion')),
        'precio'       => str_replace(',', '.', capturar('POST', 'precio')),
        'stock'        => capturar('POST', 'stock'),
        'imagen'       => sanitizar_texto(capturar('POST', 'imagen')),
        'activo'       => isset($_POST['activo']) ? 1 : 0,
    ];

    // 2) Validación en el servidor
    if (empty($datos['nombre'])) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (largo($datos['nombre']) < 2 || largo($datos['nombre']) > 100) {
        $errores['nombre'] = 'El nombre debe tener entre 2 y 100 caracteres.';
    }

    // La categoría debe ser un entero Y existir en la tabla (consulta preparada)
    $cat = filter_var($datos['categoria_id'], FILTER_VALIDATE_INT);
    if ($cat === false) {
        $errores['categoria_id'] = 'Elegí una categoría.';
    } else {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM categorias WHERE id = :id');
        $stmt->execute([':id' => $cat]);
        if ((int) $stmt->fetchColumn() === 0) {
            $errores['categoria_id'] = 'La categoría elegida no existe.';
        }
    }

    $precio = filter_var($datos['precio'], FILTER_VALIDATE_FLOAT);
    if ($precio === false || $precio < 0 || $precio > 99999999) {
        $errores['precio'] = 'El precio debe ser un número mayor o igual a 0.';
    }

    $stock = filter_var($datos['stock'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100000]]);
    if ($stock === false) {
        $errores['stock'] = 'El stock debe ser un número entero mayor o igual a 0.';
    }

    if (largo($datos['descripcion']) > 500) {
        $errores['descripcion'] = 'La descripción no puede superar los 500 caracteres.';
    }

    if ($datos['imagen'] !== '' && !preg_match('/^[\w\-.]{1,200}$/', $datos['imagen'])) {
        $errores['imagen'] = 'El nombre de imagen solo puede tener letras, números, guiones y punto.';
    }

    return [$datos, $errores];
}
