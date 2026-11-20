<?php
$titulo_pagina      = 'Servicios';
$descripcion_pagina = 'Rituales capilares de nutrición, hidratación, reconstrucción y alisados en Kora Hair.';
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="hero-centro">
      <div class="k-container">
        <span class="eyebrow eyebrow--centro">Servicios Kora</span>
        <h1 class="h-xl" style="font-size:clamp(2.4rem,5vw,4rem)">Tu cabello tiene un norte.<br><em>Vamos a encontrarlo.</em></h1>
        <p class="lead-k">Cada servicio comienza con un diagnóstico personalizado y termina con una guía clara para sostener los resultados en casa.</p>
      </div>
    </section>

    <section class="k-section" style="padding-bottom:3rem">
      <div class="k-container">
        <div class="lista-servicios">
        <a href="detalle-servicios.php" class="servicio-fila">
          <img class="servicio-fila__num servicio-fila__img" src="img/nutricion.jpg" alt="Cabello oscuro antes y después de un tratamiento de nutrición" loading="lazy">
          <div class="servicio-fila__info"><small>Ritual Kora · 60–75 min</small><h3>Nutrición</h3><p>Devolvemos lípidos y flexibilidad al cabello seco. Seleccionamos activos y técnica según tu diagnóstico.</p></div>
          <span class="servicio-fila__precio">$38.000</span>
          <span class="servicio-fila__flecha"><i class="bi bi-arrow-right"></i></span>
        </a>
        <a href="detalle-servicios.php" class="servicio-fila">
          <img class="servicio-fila__num servicio-fila__img" src="img/hidratacion.jpg" alt="Cabello castaño antes y después de un tratamiento de hidratación" loading="lazy">
          <div class="servicio-fila__info"><small>Ritual Kora · 45–60 min</small><h3>Hidratación</h3><p>Recuperamos agua, suavidad y movimiento natural. Seleccionamos activos y técnica según tu diagnóstico.</p></div>
          <span class="servicio-fila__precio">$32.000</span>
          <span class="servicio-fila__flecha"><i class="bi bi-arrow-right"></i></span>
        </a>
        <a href="detalle-servicios.php" class="servicio-fila">
          <img class="servicio-fila__num servicio-fila__img" src="img/reconstruccion.jpg" alt="Cabello rubio dañado antes y después de una reconstrucción" loading="lazy">
          <div class="servicio-fila__info"><small>Ritual Kora · 75–90 min</small><h3>Reconstrucción</h3><p>Fortalecemos la fibra dañada desde el interior. Seleccionamos activos y técnica según tu diagnóstico.</p></div>
          <span class="servicio-fila__precio">$46.000</span>
          <span class="servicio-fila__flecha"><i class="bi bi-arrow-right"></i></span>
        </a>
        <a href="detalle-servicios.php" class="servicio-fila">
          <img class="servicio-fila__num servicio-fila__img" src="img/alisados.jpg" alt="Alisado de cabello castaño con plancha en el salón" loading="lazy">
          <div class="servicio-fila__info"><small>Ritual Kora · 150–210 min</small><h3>Alisados</h3><p>Control y brillo con fórmulas de alto rendimiento. Seleccionamos activos y técnica según tu diagnóstico.</p></div>
          <span class="servicio-fila__precio">Desde $70.000</span>
          <span class="servicio-fila__flecha"><i class="bi bi-arrow-right"></i></span>
        </a>
        </div>
      </div>
    </section>

    <section style="padding-bottom:5rem">
      <div class="k-container" style="max-width:940px">
        <div class="banner-rosa">
          <div>
            <small>No sabés cuál elegir</small>
            <h2>Dejá que tu cabello<br>nos dé la respuesta.</h2>
          </div>
          <a href="test.php" class="btn-kora-blanco btn-kora">Hacer diagnóstico <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
