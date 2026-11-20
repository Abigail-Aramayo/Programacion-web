<?php
$titulo_pagina      = 'Sobre mí';
$descripcion_pagina = 'Conocé la historia y la filosofía de Kora Hair: primero te escucho, después creamos.';
$mostrar_topbar     = false;   // esta página no muestra la barra superior
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="split-hero">
      <div class="split-hero__texto">
        <span class="eyebrow">Sobre mí</span>
        <h1 class="h-xl">Primero te escucho.<br>Después, <em>creamos.</em></h1>
        <p>Kora nació de una certeza absoluta: ningún cabello debería ser tratado con una fórmula genérica. Cada melena cuenta una historia única, enfrenta desafíos diarios diferentes y merece un protocolo hecho a medida. Mi enfoque combina la estética capilar integral con un espacio de escucha activa. No se trata solo de aplicar un tratamiento, sino de devolverle la salud a la hebra capilar desde la raíz, priorizando el bienestar y la confianza de cada persona que confía en el salón. A través de “Tu Brújula Capilar”, nuestro diagnóstico personalizado, evaluamos exactamente lo que tu cabello necesita para que luzca radiante, fuerte y con vida propia, tanto en el salón como en tu rutina diaria en casa.</p>
        <a href="contacto.php" class="btn-kora mt-3">Conozcamos en el salón <i class="bi bi-arrow-right"></i></a>
      </div>
      <figure class="split-hero__foto">
        <img src="img/modelo-hero.jpg" alt="Retrato de la fundadora de Kora Hair">
        <figcaption>Fundadora &amp; Hair Expert</figcaption>
      </figure>
    </section>

    <section class="k-section">
      <div class="k-container dos-col">
        <div>
          <span class="eyebrow">Mi historia</span>
          <h2 class="h-xl">Una vocación que<br>se volvió <em>brújula.</em></h2>
        </div>
        <div>
          <p>Durante más de años aprendí que detrás de cada consulta hay mucho más que cabello: hay identidad, confianza y una historia personal.</p>
          <p>Así nació Kora Hair, un espacio de pausa y cuidado donde la técnica se encuentra con la escucha. Acá no imponemos cambios. Los diseñamos juntas.</p>
          <p class="firma">Abigail Aramayo</p>
        </div>
      </div>
    </section>

    <section class="filosofia">
      <div class="k-container">
        <span class="eyebrow eyebrow--claro">Nuestra filosofía</span>
        <h2 class="h-xl">Tres formas de cuidarte.</h2>
        <div class="filosofia__grid">
          <div class="filosofia__item"><small>01</small><h3>Escuchar</h3><p>Entender tu historia, hábitos y deseos antes de recomendar.</p></div>
          <div class="filosofia__item"><small>02</small><h3>Diagnosticar</h3><p>Leer las necesidades reales de tu fibra y cuero cabelludo.</p></div>
          <div class="filosofia__item"><small>03</small><h3>Acompañar</h3><p>Crear una rutina posible, sostenible y verdaderamente tuya.</p></div>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
