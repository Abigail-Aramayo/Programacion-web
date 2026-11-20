<?php
$titulo_pagina      = 'Contacto';
$descripcion_pagina = 'Escribinos para consultas, recomendaciones o ayuda para elegir tu tratamiento.';
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
        <form class="formulario" data-form-demo>
          <div class="fila-2">
            <div><label for="nombre">Nombre</label><input id="nombre" name="nombre" type="text" placeholder="Tu nombre" required></div>
            <div><label for="apellido">Apellido</label><input id="apellido" name="apellido" type="text" placeholder="Tu apellido" required></div>
          </div>
          <div><label for="email">Correo electrónico</label><input id="email" name="email" type="email" placeholder="nombre@correo.com" required></div>
          <div>
            <label for="motivo">Motivo de consulta</label>
            <select id="motivo" name="motivo">
              <option>Quiero asesoramiento sobre un servicio</option>
              <option>Quiero reservar un turno</option>
              <option>Consulta sobre un producto</option>
              <option>Otro motivo</option>
            </select>
          </div>
          <div><label for="mensaje">Mensaje</label><textarea id="mensaje" name="mensaje" placeholder="Contanos un poco más..."></textarea></div>
          <button type="submit" class="btn-kora">Enviar mensaje <i class="bi bi-arrow-right"></i></button>
          <p class="mensaje-ok" role="status" hidden>¡Gracias! Recibimos tu mensaje y te respondemos a la brevedad.</p>
        </form>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
