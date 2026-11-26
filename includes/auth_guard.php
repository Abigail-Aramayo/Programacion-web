<?php
/**
 * includes/auth_guard.php  -  GUARDIÁN DE RUTAS (TP8)
 * --------------------------------------------------------------
 * Se incluye AL PRINCIPIO de toda página protegida (antes de cualquier HTML):
 *
 *     $rol_requerido = 'admin';                       // opcional
 *     require_once __DIR__ . '/includes/auth_guard.php';
 *
 *  1) Si no hay sesión iniciada  -> login.php?error=acceso_denegado
 *  2) Si se pide un rol y el usuario no lo tiene -> panel.php?error=sin_permiso
 */
require_once __DIR__ . '/../config/sesion.php';
iniciar_sesion();

$base_guard = $ruta_base ?? '';   // '' en la raíz, '../' dentro de /admin

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . $base_guard . 'login.php?error=acceso_denegado');
    exit;
}

if (isset($rol_requerido) && ($_SESSION['rol'] ?? '') !== $rol_requerido) {
    header('Location: ' . $base_guard . 'panel.php?error=sin_permiso');
    exit;
}
