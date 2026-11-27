<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Controlador base: lo que comparten todos los controladores.
 *  - render():     arma la página (header + vista + footer)
 *  - redirigir():  redirección HTTP
 */
abstract class Controller
{
    /**
     * Renderiza una vista de app/Views/ dentro del layout del sitio.
     * Los datos del array quedan disponibles como variables dentro de la vista
     * (['titulo' => 'x'] -> $titulo).
     */
    protected function render(string $vista, array $variables = []): void
    {
        $variables += [
            'ruta_base'    => '../',            // los controladores se usan desde /admin
            'menu_activo'  => 'boutique.php',
        ];
        extract($variables, EXTR_SKIP);

        $raiz = dirname(__DIR__, 2);
        require_once $raiz . '/includes/header.php';       // <head>, menú (usa $titulo_pagina, $ruta_base...)
        require $raiz . '/app/Views/' . $vista . '.php';   // la vista (solo HTML)
        require_once $raiz . '/includes/footer.php';
    }

    protected function redirigir(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }
}
