<?php
/**
 * app/autoload.php  -  CARGADOR AUTOMÁTICO DE CLASES (TP10 · Parte A)
 * --------------------------------------------------------------
 * Convierte el namespace de una clase en la ruta del archivo:
 *     App\Models\ProductoModel   ->   app/Models/ProductoModel.php
 * Así no hace falta escribir un require_once por cada clase.
 */
spl_autoload_register(function (string $clase): void {
    $prefijo = 'App\\';
    if (strncmp($clase, $prefijo, strlen($prefijo)) !== 0) {
        return;                                            // no es una clase de la aplicación
    }
    $relativa = substr($clase, strlen($prefijo));          // Models\ProductoModel
    $archivo  = __DIR__ . '/' . str_replace('\\', '/', $relativa) . '.php';
    if (is_file($archivo)) {
        require $archivo;
    }
});
