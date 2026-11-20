<?php
/**
 * includes/formularios.php
 * --------------------------------------------------------------
 * Funciones de apoyo para PROCESAR FORMULARIOS de forma segura
 * (TP5 - Clase 5). Se usan en contacto.php (POST) y buscar.php (GET).
 *
 * Idea de la clase:
 *   1) CAPTURAR   -> leer $_POST / $_GET con isset / ?? y trim()
 *   2) SANITIZAR  -> limpiar la entrada (filter_var FILTER_SANITIZE_*)
 *   3) VALIDAR    -> comprobar reglas (empty, FILTER_VALIDATE_EMAIL, etc.)
 *   4) ESCAPAR    -> htmlspecialchars() justo antes de hacer echo (función e())
 */

/**
 * Lee un campo de $_POST o $_GET, de forma segura.
 * - Si la clave no existe devuelve '' (así no aparece "Undefined array key").
 * - trim() quita espacios al principio y al final.
 * - Si por algún motivo llega un array (campo[]), lo ignora.
 *
 * @param string $metodo 'POST' o 'GET'
 */
function capturar(string $metodo, string $campo): string
{
    $origen = ($metodo === 'POST') ? $_POST : $_GET;

    if (!isset($origen[$campo]) || !is_string($origen[$campo])) {
        return '';
    }
    return trim($origen[$campo]);
}

/**
 * Sanitiza un texto libre: elimina etiquetas HTML/PHP y caracteres
 * de control. Es la "limpieza de entrada" (se hace al recibir el dato).
 */
function sanitizar_texto(string $texto): string
{
    $texto = strip_tags($texto);                                  // saca <script>, <b>, etc.
    $texto = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $texto) ?? ''; // control chars
    return trim($texto);
}

/**
 * Cantidad de caracteres (cuenta bien las tildes y la ñ).
 */
function largo(string $texto): int
{
    return mb_strlen($texto, 'UTF-8');
}
