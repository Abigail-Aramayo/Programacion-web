<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 *
 * TP10 · Parte B · RUTAS del módulo "Catálogo Kora Hair".
 * Cada línea dice: método HTTP + URL  ->  Controlador::método
 */
$routes->get('/', 'Home::index');                       // página de bienvenida del framework

// Módulo con vistas (HTML)
$routes->get('catalogo', 'Catalogo::index');            // http://localhost:8080/catalogo
$routes->get('catalogo/(:num)', 'Catalogo::ver/$1');    // http://localhost:8080/catalogo/3   ((:num) -> $1)

// API REST simple (JSON)
$routes->group('api', static function (RouteCollection $routes) {
    $routes->get('productos', 'ApiProductos::index');           // http://localhost:8080/api/productos
    $routes->get('productos/(:num)', 'ApiProductos::show/$1');  // http://localhost:8080/api/productos/3
});
