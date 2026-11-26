<?php
/**
 * logout.php  -  CIERRE DE SESIÓN (TP8)
 * 1) vacía $_SESSION  2) borra la cookie de sesión del navegador
 * 3) destruye la sesión en el servidor  4) redirige al login
 */
require_once __DIR__ . '/config/sesion.php';
iniciar_sesion();

$_SESSION = [];                                   // 1) unset de las variables

if (ini_get('session.use_cookies')) {             // 2) eliminar la cookie
    $p = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires'  => time() - 42000,
        'path'     => $p['path'],
        'domain'   => $p['domain'],
        'secure'   => $p['secure'],
        'httponly' => $p['httponly'],
        'samesite' => $p['samesite'] ?: 'Lax',
    ]);
}

session_destroy();                                // 3) destruir la sesión

header('Location: login.php?logout=ok');          // 4) volver al login
exit;
