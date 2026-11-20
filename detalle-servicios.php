<?php
$titulo_pagina      = 'Detalle de servicio';
$descripcion_pagina = 'Reconstrucción molecular: protocolo profundo para cabellos dañados, elásticos o quebradizos.';
$menu_activo         = 'servicios.php';  // ítem del menú que se resalta
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="detalle-hero">
      <figure class="detalle-hero__foto">
        <img src="img/modelo-servicio.jpg" alt="Mujer con cabello largo y ondulado luego de un ritual de reconstrucción">
        <figcaption>RITUAL 03</figcaption>
      </figure>
      <div class="detalle-hero__texto">
        <span class="eyebrow">Tratamiento intensivo</span>
        <h1 class="h-xl">Reconstrucción<br><em>molecular.</em></h1>
        <p>Un protocolo profundo para cabellos dañados, elásticos o quebradizos que necesitan recuperar fuerza sin perder movimiento.</p>
        <div class="datos">
          <div><small>Duración</small><strong>75–90 min</strong></div>
          <div><small>Desde</small><strong>$46.000</strong></div>
          <div><small>Ideal cada</small><strong>4–6 semanas</strong></div>
        </div>
        <div><a href="turnos.php" class="btn-kora">Agendar este ritual <i class="bi bi-arrow-right"></i></a></div>
      </div>
    </section>

    <section class="k-section">
      <div class="k-container protocolo">
        <div>
          <span class="eyebrow">El protocolo</span>
          <h2 class="h-xl">Tu experiencia,<br><em>paso a paso.</em></h2>
        </div>
        <ul class="pasos">
            <li><small>01</small><div><h3>Diagnóstico sensorial</h3><p>Analizamos elasticidad, porosidad y nivel de daño.</p></div></li>
            <li><small>02</small><div><h3>Preparación</h3><p>Limpieza suave para recibir los activos reparadores.</p></div></li>
            <li><small>03</small><div><h3>Reconstrucción</h3><p>Aplicación por secciones y sellado con técnica térmica.</p></div></li>
            <li><small>04</small><div><h3>Guía en casa</h3><p>Tu rutina simple para prolongar el resultado.</p></div></li>
        </ul>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
