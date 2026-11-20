<?php
/**
 * contacto.php  -  FORMULARIO POR POST (TP5)
 * --------------------------------------------------------------
 * Flujo: captura -> sanitiza -> valida -> mensaje de éxito/errores.
 * Si hay errores, los campos quedan completados (persistencia).
 */
$titulo_pagina      = 'Contacto';
$descripcion_pagina = 'Escribinos para consultas, recomendaciones o ayuda para elegir tu tratamiento.';

require_once __DIR__ . '/config/env.php';          // define e(), APP_EMAIL, etc.
require_once __DIR__ . '/includes/formularios.php'; // capturar(), sanitizar_texto(), largo()

// Opciones permitidas del <select> (lista blanca: solo se acepta una de estas)
$motivos = [
    'asesoramiento' => 'Quiero asesoramiento sobre un servicio',
    'turno'         => 'Quiero reservar un turno',
    'producto'      => 'Consulta sobre un producto',
    'otro'          => 'Otro motivo',
];

// Variables de control para la vista
$errores = [];      // lista de mensajes de error
$exito   = false;   // pasa a true si todo salió bien
$datos   = ['nombre' => '', 'apellido' => '', 'email' => '', 'motivo' => 'asesoramiento', 'mensaje' => ''];

// 1) ¿Se envió el formulario por POST? (si entran escribiendo la URL, es GET y no se procesa)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2) CAPTURAR + SANITIZAR (trim + quitar etiquetas HTML)
    $datos['nombre']   = sanitizar_texto(capturar('POST', 'nombre'));
    $datos['apellido'] = sanitizar_texto(capturar('POST', 'apellido'));
    $datos['mensaje']  = sanitizar_texto(capturar('POST', 'mensaje'));
    $datos['motivo']   = capturar('POST', 'motivo');
    // El email se sanitiza con filter_var: deja solo caracteres válidos de un correo
    $datos['email']    = filter_var(capturar('POST', 'email'), FILTER_SANITIZE_EMAIL);

    // 3) VALIDAR en el servidor
    // Nombre y apellido: obligatorios, 2 a 50 caracteres, solo letras, espacios, ' - .
    foreach (['nombre' => 'Nombre', 'apellido' => 'Apellido'] as $campo => $etiqueta) {
        if (empty($datos[$campo])) {
            $errores[$campo] = "El campo $etiqueta es obligatorio.";
        } elseif (largo($datos[$campo]) < 2 || largo($datos[$campo]) > 50) {
            $errores[$campo] = "El campo $etiqueta debe tener entre 2 y 50 caracteres.";
        } elseif (!preg_match("/^[\\p{L}\\s'.\\-]+$/u", $datos[$campo])) {
            $errores[$campo] = "El campo $etiqueta solo puede tener letras y espacios.";
        }
    }

    // Email: obligatorio y con formato válido
    if (empty($datos['email'])) {
        $errores['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un correo electrónico válido (ej: nombre@correo.com).';
    }

    // Motivo: tiene que ser una de las opciones de la lista
    if (!array_key_exists($datos['motivo'], $motivos)) {
        $errores['motivo'] = 'Elegí un motivo de consulta de la lista.';
        $datos['motivo']   = 'asesoramiento';
    }

    // Mensaje: obligatorio, entre 10 y 1000 caracteres
    if (empty($datos['mensaje'])) {
        $errores['mensaje'] = 'El mensaje es obligatorio.';
    } elseif (largo($datos['mensaje']) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    } elseif (largo($datos['mensaje']) > 1000) {
        $errores['mensaje'] = 'El mensaje no puede superar los 1000 caracteres.';
    }

    // 4) Si no hay errores -> éxito (acá iría guardar en BD o enviar el mail: TP7)
    if (empty($errores)) {
        $exito = true;
        $nombre_ok = $datos['nombre'];                       // para el saludo
        $datos = ['nombre' => '', 'apellido' => '', 'email' => '', 'motivo' => 'asesoramiento', 'mensaje' => ''];
    }
}

require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="contacto">
      <div class="contacto__info">
        <span class="eyebrow">Hablemos</span>
        <h1 class="h-xl">Tu próxima historia<br>capilar <em>empieza acá.</em></h1>
        <p>Escribinos para consultas, recomendaciones o si necesitás ayuda para elegir tu tratamiento.</p>
        <ul class="datos-contacto">
          <li><i class="bi bi-geo-alt"></i><div><small>Ubicación</small><span>Bo. Castañares Grupo 298 manzana 17 casa 10, A4400 Salta</span></div></li>
          <li><i class="bi bi-whatsapp"></i><div><small>WhatsApp</small><span>https://wa.me/qr/T3TZGDJMSUQRP1</span></div></li>
          <li><i class="bi bi-envelope"></i><div><small>Correo</small><span><?= e(APP_EMAIL) ?></span></div></li>
          <li><i class="bi bi-instagram"></i><div><small>Instagram</small><span>@korahair.ar</span></div></li>
        </ul>
        <div class="horarios-salon">
          <small>Horarios del salón</small>
          Martes a viernes · 9:00 a 19:00<br>Sábados · 9:00 a 17:00
        </div>
      </div>
      <div class="contacto__form">
        <span class="eyebrow eyebrow--rosa" style="margin:0">Dejanos tu mensaje</span>
        <h2 class="h-lg" style="font-size:1.7rem;margin-top:.8rem">¿Cómo podemos ayudarte?</h2>
        <?php if ($exito): ?>
        <p class="mensaje-ok" role="status">¡Gracias, <?= e($nombre_ok) ?>! Recibimos tu mensaje y te respondemos a la brevedad.</p>
        <?php endif; ?>

        <?php if (!empty($errores)): ?>
        <div class="mensaje-error" role="alert">
          <strong>Revisá estos datos antes de enviar:</strong>
          <ul>
            <?php foreach ($errores as $error): ?>
            <li><?= e($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <!-- method="post": los datos viajan en el cuerpo de la petición (no se ven en la URL).
             novalidate: desactiva la validación del navegador para que la validación REAL (PHP) sea la que responda. -->
        <form class="formulario" method="post" action="contacto.php" novalidate>
          <div class="fila-2">
            <div>
              <label for="nombre">Nombre</label>
              <input id="nombre" name="nombre" type="text" placeholder="Tu nombre" maxlength="50" value="<?= e($datos['nombre']) ?>"<?= isset($errores['nombre']) ? ' class="campo-error"' : '' ?>>
            </div>
            <div>
              <label for="apellido">Apellido</label>
              <input id="apellido" name="apellido" type="text" placeholder="Tu apellido" maxlength="50" value="<?= e($datos['apellido']) ?>"<?= isset($errores['apellido']) ? ' class="campo-error"' : '' ?>>
            </div>
          </div>
          <div>
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" placeholder="nombre@correo.com" value="<?= e($datos['email']) ?>"<?= isset($errores['email']) ? ' class="campo-error"' : '' ?>>
          </div>
          <div>
            <label for="motivo">Motivo de consulta</label>
            <select id="motivo" name="motivo">
              <?php foreach ($motivos as $clave => $texto): ?>
              <option value="<?= e($clave) ?>"<?= $datos['motivo'] === $clave ? ' selected' : '' ?>><?= e($texto) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" placeholder="Contanos un poco más..." maxlength="1000"<?= isset($errores['mensaje']) ? ' class="campo-error"' : '' ?>><?= e($datos['mensaje']) ?></textarea>
          </div>
          <button type="submit" class="btn-kora">Enviar mensaje <i class="bi bi-arrow-right"></i></button>
        </form>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
