<?php
/**
 * login.php  -  INICIO DE SESIÓN (TP8)
 * Verifica las credenciales con password_verify() y, si son correctas,
 * regenera el ID de sesión y guarda los datos del usuario en $_SESSION.
 */
$titulo_pagina      = 'Iniciar sesión';
$descripcion_pagina = 'Ingresá para ver tus turnos, pedidos y recomendaciones.';

require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/config/sesion.php';
require_once __DIR__ . '/includes/formularios.php';
iniciar_sesion();

// Si ya está logueado no tiene sentido mostrar el login
if (isset($_SESSION['usuario_id'])) {
    header('Location: ' . (($_SESSION['rol'] ?? '') === 'admin' ? 'admin_panel.php' : 'panel.php'));
    exit;
}

// Mensajes que llegan por la URL (solo se aceptan estos valores)
$avisos = [];
if (($_GET['error'] ?? '') === 'acceso_denegado') { $avisos[] = ['error', 'Iniciá sesión para acceder a esa página.']; }
if (($_GET['registro'] ?? '') === 'ok')           { $avisos[] = ['ok', '¡Cuenta creada! Ya podés iniciar sesión.']; }
if (($_GET['logout'] ?? '') === 'ok')             { $avisos[] = ['ok', 'Cerraste sesión correctamente.']; }

$errores = [];
$email   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Capturar y sanitizar. La contraseña NO se sanitiza ni se recorta:
    //    se compara tal cual con el hash.
    $email    = mb_strtolower(filter_var(capturar('POST', 'email'), FILTER_SANITIZE_EMAIL));
    $password = (isset($_POST['password']) && is_string($_POST['password'])) ? $_POST['password'] : '';

    // 2) Validar
    if (!csrf_valido()) {
        $errores[] = 'La sesión del formulario expiró. Probá de nuevo.';
    } elseif (empty($email) || $password === '') {
        $errores[] = 'Completá el correo y la contraseña.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Ingresá un correo electrónico válido.';
    } else {
        // 3) Buscar el usuario con una consulta preparada
        try {
            $stmt = $pdo->prepare(
                'SELECT u.id, u.nombre, u.password, u.activo, r.nombre AS rol
                 FROM usuarios u
                 INNER JOIN roles r ON r.id = u.rol_id
                 WHERE u.email = :email'
            );
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch();

            // Si el usuario no existe se verifica contra un hash falso para que
            // la respuesta tarde lo mismo (no revela si el correo está registrado).
            $hash = $usuario['password'] ?? '$2y$10$usesomesillystringforeVJjKHp3E1PBU8mTGSEqRrXBhkYsK';

            // 4) password_verify compara la contraseña con el hash guardado
            if ($usuario && (int) $usuario['activo'] === 1 && password_verify($password, $hash)) {
                session_regenerate_id(true);                       // anti fijación de sesión
                $_SESSION['usuario_id']     = (int) $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['rol']            = $usuario['rol'];

                header('Location: ' . ($usuario['rol'] === 'admin' ? 'admin_panel.php' : 'panel.php'));
                exit;
            }
            $errores[] = 'Correo o contraseña incorrectos.';
        } catch (PDOException $ex) {
            error_log('login.php: ' . $ex->getMessage());
            $errores[] = 'No pudimos iniciar sesión en este momento. Intentá más tarde.';
        }
    }
}

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

        <?php foreach ($avisos as $aviso): ?>
        <p class="<?= $aviso[0] === 'ok' ? 'mensaje-ok' : 'mensaje-error' ?>" role="status"><?= e($aviso[1]) ?></p>
        <?php endforeach; ?>
        <?php if (!empty($errores)): ?>
        <div class="mensaje-error" role="alert">
          <?php foreach ($errores as $error): ?><div><?= e($error) ?></div><?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form class="formulario" method="post" action="login.php" novalidate>
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <div><label for="email">Correo electrónico</label><input id="email" name="email" type="email" placeholder="nombre@correo.com" value="<?= e($email) ?>" autocomplete="email"></div>
          <div><label for="password">Contraseña</label><input id="password" name="password" type="password" placeholder="Tu contraseña" autocomplete="current-password"></div>
          <div class="fila-opciones"><span></span><a href="#">¿Olvidé mi contraseña?</a></div>

          <button type="submit" class="btn-kora">Ingresar a mi cuenta <i class="bi bi-arrow-right"></i></button>
        </form>
        <p class="cuenta__alt">¿Todavía no tenés cuenta? <a href="registro.php">Crear cuenta</a></p>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
