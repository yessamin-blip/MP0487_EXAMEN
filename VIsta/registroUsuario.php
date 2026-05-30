<?php
session_start();
require_once __DIR__ . "/../Controller1/user.Controler.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name            = $_POST["name"];
    $email           = $_POST["email"];
    $password        = $_POST["password"];
    $password_confir = $_POST["password_confir"];
    $usuario         = 1;

    if ($password !== $password_confir) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $user_Controler = new User_Controler();
        $resultado = $user_Controler->register($name, $email, $password, $usuario, null);

        if ($resultado == "ok") {
            $_SESSION['user_email']  = $email;
            $_SESSION['user_name']   = $name;
            $_SESSION['user_id']     = $name;
            $_SESSION['user_nombre'] = $name;
            $_SESSION['user_role']   = 1;
            header("Location: home.php");
            exit();
        }

        if      ($resultado == "usuario_existe")   $mensaje = "Ese nombre de usuario ya existe.";
        elseif  ($resultado == "correo_existe")    $mensaje = "Ese correo ya está registrado.";
        elseif  ($resultado == "campos_vacios")    $mensaje = "Completa todos los campos.";
        elseif  ($resultado == "email_invalido")   $mensaje = "Email inválido.";
        elseif  ($resultado == "password_corta")   $mensaje = "La contraseña debe tener al menos 4 caracteres.";
        elseif  ($resultado == "error_base_datos") $mensaje = "Error en la base de datos, intenta más tarde.";
        else                                       $mensaje = "Error al registrar.";
    }
}

$page_title = 'SPARK · Registro';
$page_css   = 'registro.css';
include 'layout-top.php';
?>

<div class="auth-layout">

  <div class="auth-hero">
    <div class="hero-bg"></div>
    <div class="hero-grain"></div>
    <div class="hero-content">
      <a href="login.php" class="brand">
        <img src="recursos/logo.png" alt="SPARK">
      </a>
      <h1 class="hero-headline">
        <span class="line-a">EMPIEZA</span>
        <span class="line-b">tu historia.</span>
      </h1>
      <p class="hero-sub">Forma parte de la comunidad de Barcelona.</p>
    </div>
  </div>

  <div class="auth-form-wrap">
    <div class="auth-card">

      <p class="auth-eyebrow">Crear cuenta</p>
      <h2 class="auth-title">Registro</h2>

      <?php if ($mensaje): ?>
        <div class="auth-error"><?= htmlspecialchars($mensaje) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="field">
          <label>Nombre de usuario</label>
          <input type="text" name="name" placeholder="tu_nombre" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="tu@email.com" required>
        </div>
        <div class="field">
          <label>Contraseña</label>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="field">
          <label>Confirmar contraseña</label>
          <input type="password" name="password_confir" placeholder="••••••••" required>
        </div>
        <button type="submit" class="auth-btn">Crear cuenta →</button>
      </form>

      <p class="auth-footer-text">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
      </p>

    </div>
  </div>

</div>

<?php include 'layout-bottom.php'; ?>