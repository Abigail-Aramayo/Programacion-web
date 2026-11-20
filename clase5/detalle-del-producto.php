<?php
$titulo_pagina      = 'Reparador de Puntas';
$descripcion_pagina = 'Reparador de Puntas: sérum liviano de acabado sedoso que controla el frizz y potencia el brillo.';
$menu_activo         = 'boutique.php';  // ítem del menú que se resalta
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="prod-detalle">
      <div class="prod-detalle__visor">
        <button class="flecha" type="button" aria-label="Imagen anterior"><i class="bi bi-chevron-left"></i></button>
        <img class="prod-detalle__img" src="img/producto-reparador.jpg" alt="Frasco de Reparador de Puntas de 45 ml con una gota de producto">
        <div class="puntos"><i></i><i></i><i></i></div>
      </div>
      <div class="prod-detalle__info">
        <div class="migas"><a href="boutique.php">← Volver a la boutique</a><span>Tratamiento · 45 ml</span></div>
        <h1>Reparador<br><em>de Puntas.</em></h1>
        <div class="estrellas"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> 4,9 · 48 reseñas</div>
        <p class="descripcion">Un sérum liviano de acabado sedoso que controla el frizz, protege las puntas y potencia el brillo sin peso.</p>
        <p class="prod-precio">$14.500</p>
        <div class="compra">
          <div class="cantidad" data-cantidad>
            <button type="button" data-menos aria-label="Menos"><i class="bi bi-dash"></i></button>
            <span data-valor>1</span>
            <button type="button" data-mas aria-label="Más"><i class="bi bi-plus"></i></button>
          </div>
          <button class="btn-kora" type="button" data-agregar>Agregar al carrito <i class="bi bi-arrow-right"></i></button>
        </div>
        <ul class="beneficios">
          <li><i class="bi bi-check2"></i> Brillo inmediato sin efecto graso</li>
          <li><i class="bi bi-check2"></i> Protección térmica hasta 180°</li>
          <li><i class="bi bi-check2"></i> Apto para todo tipo de cabello</li>
        </ul>
        <div class="accordion acordeon-k" id="acordeonProducto">
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ingredientes" aria-expanded="true" aria-controls="ingredientes">Ingredientes clave</button></h2>
            <div id="ingredientes" class="accordion-collapse collapse show" data-bs-parent="#acordeonProducto"><div class="accordion-body">Aceite de jojoba, escualano vegetal y vitamina E. Fórmula vegana, sin siliconas pesadas.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modoUso" aria-expanded="false" aria-controls="modoUso">Modo de uso</button></h2>
            <div id="modoUso" class="accordion-collapse collapse" data-bs-parent="#acordeonProducto"><div class="accordion-body">Aplicar 2 o 3 gotas en las manos, distribuir en medios y puntas con el cabello seco o húmedo. No enjuagar.</div></div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
