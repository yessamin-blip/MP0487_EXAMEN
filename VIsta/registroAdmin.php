<?php
session_start();
require_once __DIR__ . "/../Controller1/user.Controler.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name            = $_POST['name'];
    $email           = $_POST['email'];
    $password        = $_POST['password'];
    $password_confir = $_POST["password_confir"];
    $usuario         = 2;
    $ruta            = "";

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombreImg = uniqid() . "_" . $_FILES['imagen']['name'];
        $ruta = "uploads/" . $nombreImg;
        if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    }

    if ($password !== $password_confir) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $user_Controler = new User_Controler();
        $resultado = $user_Controler->register($name, $email, $password, $usuario, $ruta);

        if ($resultado == "ok") {
            $_SESSION['user_email']  = $email;
            $_SESSION['user_name']   = $name;
            $_SESSION['user_id']     = $name;
            $_SESSION['user_nombre'] = $name;
            $_SESSION['user_role']   = 2;
            header("Location: home.php");
            exit();
        } else {
            $mensaje = "Error: " . htmlspecialchars($resultado);
        }
    }
}

$page_title = 'SPARK · Registro organizador';
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
        <span class="line-a">CREA</span>
        <span class="line-b">tu escena.</span>
      </h1>
      <p class="hero-sub">Organiza eventos que Barcelona recordará.</p>
    </div>
  </div>

  <div class="auth-form-wrap">
    <div class="auth-card">

      <p class="auth-eyebrow">Cuenta organizador</p>
      <h2 class="auth-title">Registro</h2>

      <?php if ($mensaje): ?>
        <div class="auth-error"><?= htmlspecialchars($mensaje) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="field">
          <label>Nombre de usuario</label>
          <input type="text" name="name" placeholder="tu_nombre" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="tu@email.com" required>
        </div>
        <div class="field">
          <label>Foto de perfil</label>
          <input type="file" name="imagen" accept="image/*" required>
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