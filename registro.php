<?php
/**
 * registro.php  -  REGISTRO DE USUARIOS (TP8)
 * Sanitiza, valida, verifica que el email no exista y guarda la contraseña
 * encriptada con password_hash() mediante una consulta preparada.
 */
$titulo_pagina      = 'Crear cuenta';
$descripcion_pagina = 'Registrate para reservar turnos, guardar tu diagnóstico y comprar más rápido.';

require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/config/sesion.php';
require_once __DIR__ . '/includes/formularios.php';
iniciar_sesion();

if (isset($_SESSION['usuario_id'])) {
    header('Location: panel.php');
    exit;
}

$errores = [];
$datos   = ['nombre' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Capturar y sanitizar (las contraseñas no se sanitizan: se encriptan)
    $datos['nombre'] = sanitizar_texto(capturar('POST', 'nombre'));
    $datos['email']  = mb_strtolower(filter_var(capturar('POST', 'email'), FILTER_SANITIZE_EMAIL));
    $password  = (isset($_POST['password'])  && is_string($_POST['password']))  ? $_POST['password']  : '';
    $password2 = (isset($_POST['password2']) && is_string($_POST['password2'])) ? $_POST['password2'] : '';

    // 2) Validar
    if (!csrf_valido()) {
        $errores['general'] = 'La sesión del formulario expiró. Probá de nuevo.';
    }

    if (empty($datos['nombre'])) {
        $errores['nombre'] = 'Ingresá tu nombre y apellido.';
    } elseif (largo($datos['nombre']) < 2 || largo($datos['nombre']) > 100) {
        $errores['nombre'] = 'El nombre debe tener entre 2 y 100 caracteres.';
    } elseif (!preg_match("/^[\\p{L}\\s'.\\-]+$/u", $datos['nombre'])) {
        $errores['nombre'] = 'El nombre solo puede tener letras y espacios.';
    }

    if (empty($datos['email'])) {
        $errores['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL) || largo($datos['email']) > 120) {
        $errores['email'] = 'Ingresá un correo electrónico válido.';
    }

    if ($password === '') {
        $errores['password'] = 'La contraseña es obligatoria.';
    } elseif (strlen($password) < 8) {
        $errores['password'] = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif (strlen($password) > 72) {                     // bcrypt solo usa los primeros 72 bytes
        $errores['password'] = 'La contraseña no puede superar los 72 caracteres.';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $errores['password'] = 'La contraseña debe combinar letras y números.';
    } elseif ($password !== $password2) {
        $errores['password2'] = 'Las contraseñas no coinciden.';
    }

    // 3) Si todo está bien: verificar que el email no exista y guardar
    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
            $stmt->execute([':email' => $datos['email']]);

            if ((int) $stmt->fetchColumn() > 0) {
                $errores['email'] = 'Ya existe una cuenta con ese correo electrónico.';
            } else {
                // Rol por defecto: "usuario"
                $stmt = $pdo->prepare("SELECT id FROM roles WHERE nombre = 'usuario'");
                $stmt->execute();
                $rol_id = $stmt->fetchColumn();
                if ($rol_id === false) {
                    throw new RuntimeException("No existe el rol 'usuario'. Ejecutá database/tp8_ajustes.sql");
                }

                $hash = password_hash($password, PASSWORD_BCRYPT);   // nunca se guarda la contraseña en texto plano

                $stmt = $pdo->prepare(
                    'INSERT INTO usuarios (rol_id, nombre, email, password)
                     VALUES (:rol_id, :nombre, :email, :password)'
                );
                $stmt->execute([
                    ':rol_id'   => (int) $rol_id,
                    ':nombre'   => $datos['nombre'],
                    ':email'    => $datos['email'],
                    ':password' => $hash,
                ]);

                header('Location: login.php?registro=ok');
                exit;
            }
        } catch (PDOException $ex) {
            // 23000 = clave duplicada (dos registros simultáneos con el mismo email)
            if ($ex->getCode() === '23000') {
                $errores['email'] = 'Ya existe una cuenta con ese correo electrónico.';
            } else {
                error_log('registro.php: ' . $ex->getMessage());
                $errores['general'] = 'No pudimos crear tu cuenta en este momento. Intentá más tarde.';
            }
        } catch (RuntimeException $ex) {
            error_log('registro.php: ' . $ex->getMessage());
            $errores['general'] = 'La cuenta no se pudo crear (falta configurar los roles en la base de datos).';
        }
    }
}

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

        <?php if (!empty($errores)): ?>
        <div class="mensaje-error" role="alert">
          <strong>Revisá estos datos:</strong>
          <ul><?php foreach ($errores as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form class="formulario" method="post" action="registro.php" novalidate>
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <div><label for="nombre">Nombre y apellido</label><input id="nombre" name="nombre" type="text" placeholder="Tu nombre completo" maxlength="100" value="<?= e($datos['nombre']) ?>" autocomplete="name"<?= isset($errores['nombre']) ? ' class="campo-error"' : '' ?>></div>
          <div><label for="email">Correo electrónico</label><input id="email" name="email" type="email" placeholder="nombre@correo.com" value="<?= e($datos['email']) ?>" autocomplete="email"<?= isset($errores['email']) ? ' class="campo-error"' : '' ?>></div>
          <div><label for="password">Contraseña</label><input id="password" name="password" type="password" placeholder="Mínimo 8 caracteres, con letras y números" autocomplete="new-password"<?= isset($errores['password']) ? ' class="campo-error"' : '' ?>></div>
          <div><label for="password2">Repetir contraseña</label><input id="password2" name="password2" type="password" placeholder="Repetí tu contraseña" autocomplete="new-password"<?= isset($errores['password2']) ? ' class="campo-error"' : '' ?>></div>

          <button type="submit" class="btn-kora">Crear mi cuenta <i class="bi bi-arrow-right"></i></button>
        </form>
        <p class="cuenta__alt">¿Ya tenés cuenta? <a href="login.php">Iniciar sesión</a></p>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
