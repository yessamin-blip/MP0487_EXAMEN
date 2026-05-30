<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Location: login.php');
    exit();
}

$page_title = 'SPARK · Recuperar contraseña';
$page_css   = 'password.css';
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
        <span class="line-a">¿OLVIDASTE</span>
        <span class="line-b">tu clave?</span>
      </h1>
      <p class="hero-sub">Te enviamos un enlace para recuperarla.</p>
    </div>
  </div>

  <div class="auth-form-wrap">
    <div class="auth-card">

      <p class="auth-eyebrow">Recuperación</p>
      <h2 class="auth-title">Tu email</h2>
      <p class="auth-desc">Ingresa el correo con el que te registraste.</p>

      <form action="password.php" method="POST">
        <input type="hidden" name="action" value="reset_password">
        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email"
                 placeholder="tu@email.com" required>
        </div>
        <button type="submit" class="auth-btn">Enviar enlace →</button>
      </form>

      <p class="auth-footer-text">
        <a href="login.php">← Volver a iniciar sesión</a>
      </p>

    </div>
  </div>

</div>

<?php include 'layout-bottom.php'; ?>