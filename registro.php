<?php
$titulo_pagina      = 'Crear cuenta';
$descripcion_pagina = 'Registrate para reservar turnos, guardar tu diagnóstico y comprar más rápido.';
require_once __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="cuenta">
      <div class="cuenta__foto">
        <img src="img/modelo-retrato.jpg" alt="Mujer con cabello largo, oscuro y brillante">
        <div><small>Tu espacio Kora</small><blockquote>“Un lugar para entender tu cabello, <em>a tu ritmo.</em>”</blockquote></div>
      </div>
      <div class="cuenta__form">
        <a href="index.php" class="volver">← Volver al inicio</a>
        <a class="brand" href="index.php"><span class="brand__name">KORA</span><span class="brand__sub">HAIR · TU BRÚJULA CAPILAR</span></a>
        <h1>Creá tu cuenta</h1>
        <p class="sub">Registrate para reservar turnos, guardar tu diagnóstico y comprar más rápido.</p>
        <form class="formulario" data-form-demo novalidate>
          <div><label for="nombre">Nombre y apellido</label><input id="nombre" name="nombre" type="text" placeholder="Tu nombre completo" required></div>
          <div><label for="email">Correo electrónico</label><input id="email" name="email" type="email" placeholder="nombre@correo.com" required></div>
          <div><label for="password">Contraseña</label><input id="password" name="password" type="password" placeholder="Mínimo 8 caracteres" minlength="8" required></div>
          <div><label for="password2">Repetir contraseña</label><input id="password2" name="password2" type="password" placeholder="Repetí tu contraseña" minlength="8" required></div>

          <button type="submit" class="btn-kora">Crear mi cuenta <i class="bi bi-arrow-right"></i></button>
          <p class="mensaje-ok" role="status" hidden>Formulario de demostración: la conexión con el servidor se agrega en los próximos trabajos prácticos.</p>
        </form>
        <p class="cuenta__alt">¿Ya tenés cuenta? <a href="login.php">Iniciar sesión</a></p>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
