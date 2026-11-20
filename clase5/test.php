<?php
$titulo_pagina      = 'Tu Brújula Capilar';
$descripcion_pagina = 'Respondé tres preguntas y recibí una recomendación capilar personalizada.';
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="test">
      <div class="k-container test__grid">
        <div>
          <div class="test__intro">
            <svg class="emblema" viewBox="0 0 120 120" fill="none" stroke="#fff" stroke-width=".6" aria-hidden="true">
  <circle cx="60" cy="60" r="56" opacity=".55"/>
  <ellipse cx="60" cy="60" rx="46" ry="26" transform="rotate(45 60 60)" opacity=".7"/>
  <ellipse cx="60" cy="60" rx="46" ry="26" transform="rotate(-45 60 60)" opacity=".7"/>
  <rect x="38" y="38" width="44" height="44" transform="rotate(45 60 60)" opacity=".8"/>
  <text x="60" y="10" text-anchor="middle" font-size="5" fill="#fff" stroke="none">N</text>
  <text x="60" y="73" text-anchor="middle" font-family="Playfair Display, serif" font-size="34" fill="#fff" stroke="none">K</text>
</svg>
            <div>
              <span class="eyebrow eyebrow--claro">Tu brújula capilar</span>
              <h1>Tu cabello habla. <em>Vamos a escucharlo.</em></h1>
            </div>
          </div>
          <div class="test__intro" style="grid-template-columns:1fr;margin-top:0">
            <div>
              <p>Un diagnóstico simple para orientarte hacia una rutina que realmente tenga sentido para vos.</p>
              <div class="test__meta"><span><i class="bi bi-clock"></i>3 minutos</span><span><i class="bi bi-stars"></i>Recomendación personalizada</span></div>
            </div>
          </div>
        </div>

        <div class="test-card" id="testCard">
          <div id="testPregunta">
            <span class="mini-label" id="testPaso" style="color:var(--k-rosa)">Pregunta 1 de 3</span>
            <div class="progreso"><div id="testBarra"></div></div>
            <h2 id="testTitulo">¿Cómo sentís tu cabello hoy?</h2>
            <p class="sub" id="testSub">Elegí la opción que más se acerque a vos.</p>
            <div class="opciones" id="testOpciones"></div>
          </div>
          <div class="resultado" id="testResultado" hidden>
            <div class="chispa"><i class="bi bi-stars"></i></div>
            <span class="eyebrow eyebrow--rosa eyebrow--centro" style="margin:0">Tu norte capilar</span>
            <h2>Tu cabello pide <em id="testResTexto">reconstrucción + nutrición.</em></h2>
            <p id="testResDesc">Por tus respuestas, recomendamos comenzar con un ritual reparador y sostenerlo con nutrición liviana en casa.</p>
            <div class="botones">
              <a href="turnos.php" class="btn-kora">Agendar diagnóstico <i class="bi bi-arrow-right"></i></a>
              <a href="boutique.php" class="btn-kora-borde btn-kora">Ver rutina sugerida <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
