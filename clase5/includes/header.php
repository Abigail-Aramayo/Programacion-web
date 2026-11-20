<?php
/**
 * includes/header.php
 * --------------------------------------------------------------
 * Plantilla de cabecera compartida por TODAS las páginas.
 * Contiene: <head>, metadatos, hojas de estilo, apertura de <body>
 * y (al final) la barra de navegación (nav.php).
 *
 * Cada página debe definir ANTES de incluir este archivo:
 *   $titulo_pagina      -> texto de la pestaña del navegador
 *   $descripcion_pagina -> (opcional) meta description para SEO
 *   $menu_activo        -> (opcional) archivo del menú a resaltar
 */
require_once __DIR__ . '/../config/env.php';

$titulo_pagina      = $titulo_pagina      ?? 'Inicio';
$descripcion_pagina = $descripcion_pagina ?? APP_NAME . ', tu brújula capilar.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= e($descripcion_pagina) ?>">
  <title><?= e($titulo_pagina) ?> | <?= e(APP_NAME) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php require_once __DIR__ . '/nav.php'; ?>
