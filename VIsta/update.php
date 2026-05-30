<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../Controller1/user.Controler.php';
$user_Controler = new User_Controler();
$error = "";

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $ruta = null;

    if ($_SESSION['user_role'] == 2 && isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $destino = 'recursos/' . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
        $ruta = $destino;
    }

    $resultado = $user_Controler->updateProfile(
        $_POST['nombre'],
        $_POST['email'],
        $_POST['password'],
        $ruta
    );

    if ($resultado == "ok") {
        header('Location: perfil.php');
        exit();
    } else {
        $error = match($resultado) {
            "email_invalido"            => "El email no es válido.",
            "password_corta"            => "La contraseña debe tener al menos 4 caracteres.",
            "usuario_existe"            => "Ese nombre de usuario ya existe.",
            "correo_existe"             => "Ese correo ya está en uso.",
            "usuario_o_email_duplicado" => "El usuario o correo ya existen.",
            default                     => "Error al actualizar."
        };
    }
}

$page_title = 'SPARK · Editar perfil';
$page_css   = 'editarEvento.css';
$page_css2  = 'eliminar.css';
$page_js    = 'js/eliminar.js';
include 'layout-top.php';
?>

<header class="topbar">
  <a href="home.php" class="nav-logo">
    <img src="recursos/logo.png" alt="SPARK">
  </a>
  <nav class="menu">
    <a href="home.php">Home</a>
    <a href="https://www.google.com/maps" target="_blank">Mapa</a>
    <a href="foro.php">Foro</a>
  </nav>
  <div class="actions">
    <a href="logout.php" class="login">Cerrar sesión</a>
  </div>
</header>

<div class="update-layout">
  <div class="edit-card">

    <div class="edit-card-header">
      <div>
        <p class="edit-eyebrow">Tu cuenta</p>
        <h2 class="edit-title">Editar perfil</h2>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="form-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulario de edición -->
    <form action="update.php" method="POST" enctype="multipart/form-data">
      <div class="field">
        <label>Nombre de usuario</label>
        <input type="text" name="nombre"
               value="<?= htmlspecialchars($_SESSION['user_nombre']) ?>" required>
      </div>
      <div class="field">
        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($_SESSION['user_email']) ?>" required>
      </div>
      <div class="field">
        <label>Contraseña</label>
        <input type="password" name="password" placeholder="Nueva contraseña" required>
      </div>
      <?php if ($_SESSION['user_role'] == 2): ?>
      <div class="field">
        <label>Imagen de perfil</label>
        <input type="file" name="imagen" accept="image/*">
      </div>
      <?php endif; ?>

      <div class="form-actions">
        <!-- Botón eliminar — abre el modal -->
        <button type="button" class="btn-delete" id="btnEliminar">
          Eliminar cuenta
        </button>
        <a href="perfil.php" class="btn-cancel">Cancelar</a>
        <button type="submit" name="action" value="update" class="btn-save">
          Guardar cambios →
        </button>
      </div>
    </form>

  </div>
</div>

<!-- Formulario oculto que apunta a eliminar.php -->
<form action="eliminar.php" method="POST" id="deleteForm">
  <input type="hidden" name="confirmar" value="si">
</form>

<!-- Modal de confirmación -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal-box">
    <div class="modal-icon">⚠️</div>
    <h3 class="modal-title">Última confirmación</h3>
    <p class="modal-desc">
      ¿Estás completamente segura? Esta acción eliminará tu cuenta
      y todos tus datos de forma <strong>irreversible</strong>.
    </p>
    <div class="modal-actions">
      <button class="modal-cancel" id="modalCancelar">No, volver</button>
      <button class="modal-confirm" id="modalConfirmar">Eliminar cuenta</button>
    </div>
  </div>
</div>

<?php include 'layout-bottom.php'; ?>