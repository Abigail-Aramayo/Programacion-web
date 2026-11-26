<?php
/**
 * config/env.php
 * --------------------------------------------------------------
 * Lee el archivo .env de la raíz del proyecto y deja sus valores
 * disponibles en todo el sitio como constantes (APP_NAME, etc.).
 *
 * Se incluye UNA sola vez desde includes/header.php.
 * Si el .env no existe, se usan los valores por defecto de abajo.
 */

// Ruta de la raíz del proyecto (la carpeta que contiene /config)
define('BASE_PATH', dirname(__DIR__));

/**
 * Lee un archivo .env y devuelve un array clave => valor.
 * Ignora líneas vacías y comentarios (los que empiezan con #).
 */
function cargar_env(string $ruta): array
{
    $variables = [];

    if (!is_readable($ruta)) {
        return $variables; // no hay .env: se usarán los valores por defecto
    }

    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        $linea = trim($linea);

        // saltar comentarios y líneas sin "="
        if ($linea === '' || $linea[0] === '#' || !str_contains($linea, '=')) {
            continue;
        }

        [$clave, $valor] = explode('=', $linea, 2);
        $variables[trim($clave)] = trim(trim($valor), "\"'"); // quita comillas
    }

    return $variables;
}

$env = cargar_env(BASE_PATH . '/.env');

// Variables globales del sitio
define('APP_NAME',  $env['APP_NAME']  ?? 'Kora Hair');
define('APP_EMAIL', $env['APP_EMAIL'] ?? 'contacto@ejemplo.com');
define('APP_ENV',   $env['APP_ENV']   ?? 'local');

// Datos de conexión a MySQL (TP7). Valores por defecto de XAMPP.
define('DB_HOST',    $env['DB_HOST']    ?? 'localhost');
define('DB_NAME',    $env['DB_NAME']    ?? 'kora_hair');
define('DB_USER',    $env['DB_USER']    ?? 'root');
define('DB_PASS',    $env['DB_PASS']    ?? '');
define('DB_CHARSET', $env['DB_CHARSET'] ?? 'utf8mb4');

// En entorno local se muestran los errores; en producción, no.
ini_set('display_errors', APP_ENV === 'local' ? '1' : '0');
error_reporting(E_ALL);

/**
 * Escapa texto antes de imprimirlo en HTML (evita inyección de código).
 * Uso: <?= e($variable) ?>
 */
function e(?string $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}
