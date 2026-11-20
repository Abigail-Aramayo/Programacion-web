<?php
/**
 * includes/footer.php
 * --------------------------------------------------------------
 * Pie de página compartido + scripts de JavaScript.
 * Cierra las etiquetas <body> y <html> abiertas en header.php.
 */
?>

  <footer class="site-footer">
    <div class="k-container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a class="brand" href="index.php"><span class="brand__name">KORA</span><span class="brand__sub">HAIR · TU BRÚJULA CAPILAR</span></a>
          <p class="footer-lema">Cuidamos tu cabello.<br>Acompañamos tu historia.</p>
          <a class="footer-mail" href="mailto:<?= e(APP_EMAIL) ?>"><?= e(APP_EMAIL) ?></a>
        </div>
        <div>
          <h4 class="footer-titulo">Explorar</h4>
          <ul class="footer-links">
            <li><a href="servicios.php">Servicios</a></li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="test.php">Test capilar</a></li>
          </ul>
        </div>
        <div>
          <h4 class="footer-titulo">Ayuda</h4>
          <ul class="footer-links">
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="turnos.php">Agendar turno</a></li>
            <li><a href="login.php">Mi cuenta</a></li>
          </ul>
        </div>
        <div class="footer-news">
          <h4 class="footer-titulo">Carta de Kora</h4>
          <h4>Consejos que sí le sirven<br>a tu cabello.</h4>
          <form class="news-form" data-form-demo>
            <input type="email" placeholder="Tu correo electrónico" aria-label="Tu correo electrónico" required>
            <button type="submit" aria-label="Suscribirme"><i class="bi bi-arrow-right"></i></button>
          </form>
        </div>
      </div>
      <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> <?= e(APP_NAME) ?>. Todos los derechos reservados.</span>
        <span>Salta, Argentina</span>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
