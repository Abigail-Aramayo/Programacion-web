<?php
/**
 * config/catalogo.php
 * --------------------------------------------------------------
 * Pequeño "catálogo" en un array para el buscador (buscar.php).
 * Más adelante (TP6/TP7) estos datos van a venir de MySQL.
 */
return [
    ['tipo' => 'servicios', 'nombre' => 'Nutrición',      'detalle' => 'Ritual Kora · 60–75 min. Devolvemos lípidos y flexibilidad al cabello seco. $38.000',        'url' => 'detalle-servicios.php'],
    ['tipo' => 'servicios', 'nombre' => 'Hidratación',    'detalle' => 'Ritual Kora · 45–60 min. Recuperamos agua, suavidad y movimiento natural. $32.000',           'url' => 'detalle-servicios.php'],
    ['tipo' => 'servicios', 'nombre' => 'Reconstrucción', 'detalle' => 'Ritual Kora · 75–90 min. Fortalecemos la fibra dañada desde el interior. $46.000',             'url' => 'detalle-servicios.php'],
    ['tipo' => 'servicios', 'nombre' => 'Alisados',       'detalle' => 'Ritual Kora · 150–210 min. Control y brillo con fórmulas de alto rendimiento. Desde $70.000', 'url' => 'detalle-servicios.php'],
    ['tipo' => 'productos', 'nombre' => 'Reparador de Puntas',       'detalle' => 'Tratamiento · Reparación y brillo · $14.500', 'url' => 'detalle-del-producto.php'],
    ['tipo' => 'productos', 'nombre' => 'Shampoo Extra-Suave',       'detalle' => 'Limpieza · Limpieza delicada · $11.800',      'url' => 'detalle-del-producto.php'],
    ['tipo' => 'productos', 'nombre' => 'Máscara Nutritiva Keratina','detalle' => 'Nutrición · Nutrición profunda · $18.900',    'url' => 'detalle-del-producto.php'],
];
