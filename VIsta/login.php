<?php
// UserController.php

session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: home.php');
  exit();
}


require_once __DIR__ . '/../Controller1/user.Controler.php';


$user_Controler = new User_Controler();

$error_mensaje = "";

if (isset($_POST['action']) && $_POST['action'] == 'login') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $user = $user_Controler->login($email, $password);

  if ($user && is_array($user)) {
    $_SESSION['user_id'] = $user['Nombre_Usuario'];
    $_SESSION['user_nombre'] = $user['Nombre_Usuario'];
    $_SESSION['user_email'] = $user['Correo'];
    $_SESSION['user_role'] = $user['id_perfil'];
    header('Location: perfil.php');
    exit();
  } else {
    $error_mensaje = "Correo o contraseña incorrectos.";
  }
}
$page_title = 'SPARK · Iniciar sesión';
$page_css   = 'login.css';
include 'layout-top.php';
?>



<div class="auth-layout">

  <!-- LADO IZQUIERDO — hero oscuro -->
  <div class="auth-hero">
    <div class="hero-bg"></div>



    <img class="hero-logo" src="recursos/logo.png" alt="SPARK">

    <div class="hero-grain"></div>

    <div class="hero-content">


    </div>
  </div>

  <!-- LADO DERECHO — formulario -->
  <div class="auth-form-wrap">
    <div class="auth-card">

      <p class="auth-eyebrow">Tu cuenta</p>
      <h2 class="auth-title">Iniciar sesión</h2>

      <div id="cookieGate" style="display:none">
        <p style="color:#9A9186; font-size:14px; margin-bottom:16px;">
          Debes aceptar el uso de cookies para poder iniciar sesión.
        </p>
        <button type="button" onclick="mostrarBanner()"
          style="width:100%; padding:14px; background:#1A1714; color:#E8D48A;
                 border:none; border-radius:12px; font-size:15px; font-weight:700;
                 cursor:pointer; font-family:'Bebas Neue',sans-serif; letter-spacing:1px;">
          Ver aviso de cookies
        </button>
      </div>

      <div id="loginFormWrap">

        <form method="POST" action="login.php">
          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="tu@email.com" required>
          </div>

          <div class="field">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
          </div>

          <a class="forgot-link" href="password.php">¿Olvidaste tu contraseña?</a>

          <button type="submit" name="action" value="login" class="auth-btn">Entrar →</button>
        </form>
      </div><!-- /loginFormWrap -->

      <script>
        $(function() {
          if (!localStorage.getItem('spark_cookies')) {
            $('#loginFormWrap').hide();
            $('#cookieGate').show();
          }
        });
      </script>

      <p class="auth-footer-text">
        ¿No tienes cuenta? <a href="tipoUsuario.php">Únete a SPARK</a>
      </p>

    </div>
  </div>

</div>
<?php include 'layout-bottom.php'; ?>