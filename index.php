<?php
$titulo_pagina      = 'Inicio';
$descripcion_pagina = 'Kora Hair, tu brújula capilar. Salón de tratamientos capilares personalizados y boutique de productos.';
$mostrar_topbar     = false;   // esta página no muestra la barra superior
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="hero">
      <div class="hero__texto">
        <span class="eyebrow">Bienvenida a Kora Hair</span>
        <h1 class="h-display">Tu cabello.<br>Tu esencia.<br><em>Tu brújula.</em></h1>
        <p class="lead-k">Experiencias capilares diseñadas para revelar la mejor versión de tu cabello, sin dejar de ser vos.</p>
        <div class="hero__botones">
          <a href="turnos.php" class="btn-kora">Agendar mi experiencia <i class="bi bi-arrow-right"></i></a>
          <a href="servicios.php" class="link-flecha">Descubrir mi rutina <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
      <div class="hero__foto">
        <img src="img/modelo-hero.jpg" alt="Mujer con cabello largo, oscuro y ondulado, de saco negro">
        <div class="hero__tarjeta">
          <small><i class="bi bi-stars"></i> Nuestro enfoque</small>
          <strong>Belleza que empieza con salud capilar</strong>
        </div>
        <span class="hero__vertical">KORA · HAIR · EXPERT</span>
      </div>
    </section>

    <section class="afirmacion">
      <div class="k-container afirmacion__grid">
        <span class="afirmacion__num">01</span>
        <h2>No seguimos tendencias. <em>Seguimos tu cabello.</em></h2>
        <p>Cada hebra cuenta una historia. Por eso combinamos diagnóstico, técnica y productos de alto rendimiento para crear un plan tan único como vos.</p>
      </div>
    </section>

    <section class="k-section">
      <div class="k-container">
        <div class="sec-head">
          <div>
            <span class="eyebrow">Tratamientos a tu medida</span>
            <h2 class="h-xl">El ritual que tu<br>cabello <em>necesita.</em></h2>
          </div>
          <a href="servicios.php" class="link-flecha">Ver todos los servicios <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="rituales">
          <a href="detalle-servicios.php" class="ritual-card">
            <div class="ritual-card__arte" style="background:#EFE2DF"><span>01</span>
            <svg viewBox="0 0 400 225" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
              <ellipse cx="270" cy="115" rx="105" ry="170" transform="rotate(18 270 115)" fill="#DDD0CC"/>
              <ellipse cx="285" cy="115" rx="95" ry="160" transform="rotate(18 285 115)" fill="#CFC0BC"/>
              <ellipse cx="300" cy="115" rx="85" ry="150" transform="rotate(18 300 115)" fill="#EFE2DF" stroke="#161414" stroke-width=".6"/>
            </svg></div>
            <div class="ritual-card__cuerpo">
              <small>60–75 MIN</small>
              <h3>Nutrición</h3>
              <p>Devolvemos lípidos y flexibilidad al cabello seco.</p>
              <i class="bi bi-arrow-right"></i>
            </div>
          </a>
          <a href="detalle-servicios.php" class="ritual-card">
            <div class="ritual-card__arte" style="background:#D8C1C3"><span>02</span>
            <svg viewBox="0 0 400 225" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
              <ellipse cx="270" cy="115" rx="105" ry="170" transform="rotate(18 270 115)" fill="#C7B0B2"/>
              <ellipse cx="285" cy="115" rx="95" ry="160" transform="rotate(18 285 115)" fill="#BBA4A6"/>
              <ellipse cx="300" cy="115" rx="85" ry="150" transform="rotate(18 300 115)" fill="#D8C1C3" stroke="#161414" stroke-width=".6"/>
            </svg></div>
            <div class="ritual-card__cuerpo">
              <small>45–60 MIN</small>
              <h3>Hidratación</h3>
              <p>Recuperamos agua, suavidad y movimiento natural.</p>
              <i class="bi bi-arrow-right"></i>
            </div>
          </a>
          <a href="detalle-servicios.php" class="ritual-card">
            <div class="ritual-card__arte" style="background:#D9D3CF"><span>03</span>
            <svg viewBox="0 0 400 225" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
              <ellipse cx="270" cy="115" rx="105" ry="170" transform="rotate(18 270 115)" fill="#C9C2BD"/>
              <ellipse cx="285" cy="115" rx="95" ry="160" transform="rotate(18 285 115)" fill="#BDB5B0"/>
              <ellipse cx="300" cy="115" rx="85" ry="150" transform="rotate(18 300 115)" fill="#D9D3CF" stroke="#161414" stroke-width=".6"/>
            </svg></div>
            <div class="ritual-card__cuerpo">
              <small>75–90 MIN</small>
              <h3>Reconstrucción</h3>
              <p>Fortalecemos la fibra dañada desde el interior.</p>
              <i class="bi bi-arrow-right"></i>
            </div>
          </a>
        </div>
      </div>
    </section>

    <section class="banda-brujula">
      <div class="k-container banda-brujula__grid">
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
          <h2>¿No sabés qué necesita tu cabello? <em>Te guiamos.</em></h2>
          <p>Respondé unas preguntas rápidas y recibí una recomendación personalizada para tu tipo de cabello.</p>
          <a href="test.php" class="btn-kora-blanco btn-kora mt-3">Hacer el test <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </section>

    <section class="k-section">
      <div class="k-container">
        <div class="sec-head">
          <div>
            <span class="eyebrow">La boutique Kora</span>
            <h2 class="h-xl">El salón,<br><em>en tu casa.</em></h2>
          </div>
          <a href="boutique.php" class="link-flecha">Explorar boutique <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="productos productos--3">
          <article class="producto" data-categoria="tratamiento">
            <a href="detalle-del-producto.php" class="producto__img producto__img--negro" aria-label="Ver Reparador de Puntas">
              <span class="producto__tag">Más vendido</span>
              <img src="img/producto-reparador.jpg" alt="Frasco de Reparador de Puntas Influencia Profesional de 45 ml" loading="lazy">
            </a>
            <button class="producto__fav" type="button" aria-label="Guardar en favoritos"><i class="bi bi-heart"></i></button>
            <div class="producto__info">
              <span class="producto__cat">Tratamiento</span>
              <h3><a href="detalle-del-producto.php">Reparador de Puntas</a></h3>
              <p class="producto__desc">Reparación &amp; brillo</p>
              <div class="producto__fila">
                <span class="producto__precio">$14.500</span>
                <button class="mas-btn" type="button" data-agregar aria-label="Agregar Reparador de Puntas al carrito"><i class="bi bi-plus"></i></button>
              </div>
            </div>
          </article>
          <article class="producto" data-categoria="limpieza">
            <a href="detalle-del-producto.php" class="producto__img producto__img--blanco" aria-label="Ver Shampoo Extra-Suave">
              <span class="producto__tag">Nuevo</span>
              <img src="img/producto-shampoo.jpg" alt="Shampoo Extra-Suave Ducray de 200 ml" loading="lazy">
            </a>
            <button class="producto__fav" type="button" aria-label="Guardar en favoritos"><i class="bi bi-heart"></i></button>
            <div class="producto__info">
              <span class="producto__cat">Limpieza</span>
              <h3><a href="detalle-del-producto.php">Shampoo Extra-Suave</a></h3>
              <p class="producto__desc">Limpieza delicada</p>
              <div class="producto__fila">
                <span class="producto__precio">$11.800</span>
                <button class="mas-btn" type="button" data-agregar aria-label="Agregar Shampoo Extra-Suave al carrito"><i class="bi bi-plus"></i></button>
              </div>
            </div>
          </article>
          <article class="producto" data-categoria="nutricion">
            <a href="detalle-del-producto.php" class="producto__img producto__img--foto" aria-label="Ver Máscara Nutritiva Keratina">
              <img src="img/producto-mascara.jpg" alt="Máscara Nutritiva con Keratina, jojoba y lino" loading="lazy">
            </a>
            <button class="producto__fav" type="button" aria-label="Guardar en favoritos"><i class="bi bi-heart"></i></button>
            <div class="producto__info">
              <span class="producto__cat">Nutrición</span>
              <h3><a href="detalle-del-producto.php">Máscara Nutritiva Keratina</a></h3>
              <p class="producto__desc">Nutrición profunda</p>
              <div class="producto__fila">
                <span class="producto__precio">$18.900</span>
                <button class="mas-btn" type="button" data-agregar aria-label="Agregar Máscara Nutritiva Keratina al carrito"><i class="bi bi-plus"></i></button>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="cita">
      <div class="k-container">
        <i class="bi bi-stars"></i>
        <blockquote>“Tu cabello no necesita ser perfecto. Necesita ser <em>comprendido.</em>”</blockquote>
        <cite>— Kora Hair</cite>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
