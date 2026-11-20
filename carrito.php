<?php
$titulo_pagina      = 'Carrito de compras';
$descripcion_pagina = 'Tu selección de productos Kora Hair.';
$menu_activo         = 'boutique.php';  // ítem del menú que se resalta
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="hero-centro" style="padding-block:3rem">
      <div class="k-container">
        <span class="eyebrow eyebrow--centro">Tu selección</span>
        <h1 class="h-xl">Carrito de <em>compras.</em></h1>
      </div>
    </section>

    <section class="k-section" style="padding-block:3rem 5rem">
      <div class="k-container">
        <div class="carrito">
          <div>
            <div class="carrito__cab"><span>Producto</span><span>Cantidad</span><span>Total</span></div>
            <div id="carritoItems">
              <div class="carrito-item" data-precio="14500">
                <div class="carrito-item__prod">
                  <div class="carrito-item__mini"><img src="img/producto-reparador.jpg" alt="Reparador de Puntas"></div>
                  <div><small>Tratamiento</small><h3>Reparador de Puntas</h3><button class="quitar" type="button" data-quitar>Eliminar</button></div>
                </div>
                <div class="cantidad" data-cantidad>
                  <button type="button" data-menos aria-label="Menos"><i class="bi bi-dash"></i></button>
                  <span data-valor>1</span>
                  <button type="button" data-mas aria-label="Más"><i class="bi bi-plus"></i></button>
                </div>
                <div class="carrito-item__total" data-total-item>$14.500</div>
              </div>
            </div>
            <p class="carrito-vacio" id="carritoVacio" hidden>Tu carrito está vacío. <a href="boutique.php" class="link-flecha">Ir a la boutique</a></p>
          </div>
          <aside class="resumen-pedido">
            <span class="mini-label">Resumen</span>
            <h3>Tu pedido</h3>
            <div class="fila"><span>Subtotal</span><span id="subtotal">$14.500</span></div>
            <div class="fila"><span>Envío</span><span>A calcular</span></div>
            <div class="fila total"><span>Total</span><span id="totalPedido">$14.500</span></div>
            <a href="contacto.php" class="btn-kora">Continuar al pago <i class="bi bi-arrow-right"></i></a>
            <p class="seguro"><i class="bi bi-check2"></i> Compra segura · Cambios dentro de 30 días</p>
          </aside>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
