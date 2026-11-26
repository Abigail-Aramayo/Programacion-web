<?php
/**
 * config/sesion.php
 * --------------------------------------------------------------
 * Manejo seguro de sesiones (TP8).
 *  - iniciar_sesion():  session_start() con cookie segura
 *  - csrf_token() / csrf_valido():  token anti-CSRF para los formularios
 */

function iniciar_sesion(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;   // ya está iniciada
    }

    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    // La cookie de sesión no es accesible desde JavaScript (httponly),
    // solo viaja por HTTPS si el sitio usa HTTPS (secure) y no se envía en
    // peticiones de otros sitios (samesite).
    session_set_cookie_params([
        'lifetime' => 0,          // dura hasta cerrar el navegador
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    ini_set('session.use_strict_mode', '1');   // rechaza IDs de sesión inventados
    session_start();
}

/** Devuelve el token CSRF de la sesión (lo crea si no existe). */
function csrf_token(): string
{
    iniciar_sesion();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Compara el token recibido por POST con el de la sesión. */
function csrf_valido(): bool
{
    iniciar_sesion();
    $enviado = $_POST['csrf'] ?? '';
    return is_string($enviado) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $enviado);
}
