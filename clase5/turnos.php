<?php
$titulo_pagina      = 'Agendar turno';
$descripcion_pagina = 'Reservá tu turno en Kora Hair: elegí el día y el horario que mejor te quede.';
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="hero-centro" style="padding-bottom:3.5rem">
      <div class="k-container">
        <span class="eyebrow eyebrow--centro">Reservá tu momento</span>
        <h1 class="h-xl" style="font-size:clamp(2.4rem,5vw,3.8rem)">Tu próxima experiencia<br><em>empieza acá.</em></h1>
        <div class="pasos-reserva" aria-label="Paso 1 de 3"><span class="on">1</span><hr><span>2</span><hr><span>3</span></div>
      </div>
    </section>

    <div class="reserva-wrap">
      <div class="k-container">
        <div class="reserva" id="reserva">
          <div class="cal">
            <div class="cal__nav">
              <button type="button" id="calPrev" aria-label="Mes anterior"><i class="bi bi-chevron-left"></i></button>
              <strong id="calMes">Mes</strong>
              <button type="button" id="calNext" aria-label="Mes siguiente"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="cal__grid" id="calGrid"></div>
          </div>
          <div class="horarios">
            <span class="mini-label" id="horaFecha">Elegí un día</span>
            <h3>Horarios disponibles</h3>
            <div class="horarios__lista" id="horasLista"></div>
            <p class="horarios__nota"><i class="bi bi-circle-fill"></i> Los horarios se muestran en la zona local.</p>
          </div>
          <aside class="resumen">
            <span class="mini-label">Tu reserva</span>
            <h3>Resumen de la cita</h3>
            <ul>
              <li><i class="bi bi-calendar3"></i><div><small>Fecha</small><strong id="resFecha">A seleccionar</strong></div></li>
              <li><i class="bi bi-clock"></i><div><small>Hora</small><strong id="resHora">A seleccionar</strong></div></li>
              <li><i class="bi bi-stars"></i><div><small>Servicio</small><strong>A seleccionar</strong></div></li>
            </ul>
            <a href="contacto.php" class="btn-kora" id="btnContinuar">Continuar <i class="bi bi-arrow-right"></i></a>
            <p>No se realiza ningún cobro online</p>
          </aside>
        </div>
      </div>
    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
