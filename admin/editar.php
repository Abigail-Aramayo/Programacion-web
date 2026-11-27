<?php
/**
 * admin/editar.php  -  punto de entrada (TP10: MVC)
 * Ya no tiene SQL ni HTML: protege la página y delega en el controlador.
 */
$ruta_base     = '../';
$rol_requerido = 'admin';                                    // TP8: solo administradores
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../config/conexion.php';            // crea $pdo
require_once __DIR__ . '/../app/autoload.php';

(new App\Controllers\ProductoController($pdo))->editar();
