<?php
/**
 * config/conexion.php
 * --------------------------------------------------------------
 * Conexión a MySQL con PDO (TP7).
 * Los datos salen del archivo .env (ver config/env.php).
 *
 * Uso en cualquier página:
 *     require_once __DIR__ . '/../config/conexion.php';
 *     $stmt = $pdo->prepare('SELECT ...');
 *
 * Se maneja la excepción PDOException con try-catch para que, si
 * la base no responde, no se muestren claves ni rutas internas.
 */
require_once __DIR__ . '/env.php';

$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // los errores lanzan excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // filas como arrays asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                    // consultas preparadas REALES
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $opciones);
} catch (PDOException $e) {
    error_log('Error de conexión a la base de datos: ' . $e->getMessage());
    http_response_code(500);
    $detalle = (APP_ENV === 'local')
        ? ' Detalle (solo visible en local): ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')
        : '';
    die('<p style="font-family:sans-serif;padding:2rem">No pudimos conectar con la base de datos. '
      . 'Verificá que MySQL esté iniciado en XAMPP y que hayas importado database/schema.sql.' . $detalle . '</p>');
}
