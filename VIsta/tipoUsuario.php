<?php
if (isset($_POST['tipo'])) {
    $tipo = $_POST['tipo'];
    if ($tipo == "organizador") {
        header("Location: registroAdmin.php");
    } else {
        header("Location: registroUsuario.php");
    }
    exit();
}

$page_title = 'SPARK · Únete';
$page_css   = 'tipoUsuario.css';
$page_js = 'js/tipoUsuario.js';
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
        <span class="line-a">ÚNETE</span>
        <span class="line-b">a la escena.</span>
      </h1>
      <p class="hero-sub">Elige cómo quieres vivir Barcelona.</p>
    </div>
  </div>

  <div class="auth-form-wrap">
    <div class="auth-card">

      <p class="auth-eyebrow">Paso 1 de 2</p>
      <h2 class="auth-title">¿Quién eres?</h2>
      <p class="auth-desc">Selecciona tu rol para personalizar tu experiencia.</p>

      <form method="POST" action="tipoUsuario.php" id="tipoForm">
        <input type="hidden" name="tipo" id="tipoInput" value="usuario">

        <div class="tipo-options">
          <button type="button" class="tipo-opt active" data-val="usuario">
            <div class="opt-icon">🎟️</div>
            <div>
              <strong>Asistente</strong>
              <span>Descubre y reserva eventos en Barcelona</span>
            </div>
          </button>

          <button type="button" class="tipo-opt" data-val="organizador">
            <div class="opt-icon">🎤</div>
            <div>
              <strong>Organizador</strong>
              <span>Crea y gestiona tus propios eventos</span>
            </div>
          </button>
        </div>

        <button type="submit" class="auth-btn">Continuar →</button>
      </form>

      <p class="auth-footer-text">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
      </p>

    </div>
  </div>

</div>



<?php include 'layout-bottom.php'; ?>