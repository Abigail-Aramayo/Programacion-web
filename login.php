<?php
$titulo_pagina      = 'Iniciar sesión';
$descripcion_pagina = 'Ingresá para ver tus turnos, pedidos y recomendaciones.';
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="cuenta">
      <div class="cuenta__foto">
        <img src="img/modelo-retrato.jpg" alt="Mujer con cabello largo, oscuro y brillante">
        <div><small>Tu espacio Kora</small><blockquote>“El cuidado real empieza cuando conocés tu <em>cabello.</em>”</blockquote></div>
      </div>
      <div class="cuenta__form">
        <a href="index.php" class="volver">← Volver al inicio</a>
        <a class="brand" href="index.php"><span class="brand__name">KORA</span><span class="brand__sub">HAIR · TU BRÚJULA CAPILAR</span></a>
        <h1>Qué lindo verte.</h1>
        <p class="sub">Ingresá para ver tus turnos, pedidos y recomendaciones.</p>
        <form class="formulario" data-form-demo novalidate>
          <div><label for="email">Correo electrónico</label><input id="email" name="email" type="email" placeholder="nombre@correo.com" required></div>
          <div><label for="password">Contraseña</label><input id="password" name="password" type="password" placeholder="Mínimo 8 caracteres" minlength="8" required></div>
          <div class="fila-opciones"><label><input type="checkbox" name="recordarme"> Recordarme</label><a href="#">¿Olvidé mi contraseña?</a></div>

          <button type="submit" class="btn-kora">Ingresar a mi cuenta <i class="bi bi-arrow-right"></i></button>
          <p class="mensaje-ok" role="status" hidden>Formulario de demostración: la conexión con el servidor se agrega en los próximos trabajos prácticos.</p>
        </form>
        <p class="cuenta__alt">¿Todavía no tenés cuenta? <a href="registro.php">Crear cuenta</a></p>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
