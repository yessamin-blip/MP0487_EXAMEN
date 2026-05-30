<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}
require_once __DIR__ . '/../Controller1/user.Controler.php';
$userController = new User_Controler();
$user = $userController->getUserById($_SESSION['user_id']);

$page_title = 'SPARK · Perfil';
$page_css   = 'perfil.css';
include 'layout-top.php';
?>



<!-- ── NAV ──────────────────────────────────────── -->
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
    <select id="español">
      <option>Español</option>
      <option>English</option>
      <option>Català</option>
    </select>
  </div>
</header>

<!-- ── HERO PERFIL ────────────────────────────────── -->
<section class="profile-hero">
  <div class="profile-hero__bg"></div>
  <div class="profile-hero__grain"></div>
  <div class="profile-hero__overlay"></div>

  <div class="profile-hero__inner">

    <!-- Avatar -->
    <div class="avatar-wrap">
      <img class="avatar"
           src="<?= htmlspecialchars($user['Imagen'] ?? 'recursos/pfp.png') ?>"
           alt="Foto de perfil">
      <a href="update.php" class="edit-icon" title="Editar perfil">
        <img src="recursos/edit.png" alt="Editar">
      </a>
    </div>

    <!-- Nombre + bio -->
    <div class="profile-text">
      <div class="profile-info">
        <h1><?= htmlspecialchars($user['Nombre_Usuario']) ?></h1>
        <span>@<?= htmlspecialchars($user['Nombre_Usuario']) ?></span>
      </div>
      <p class="bio-text">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi.
      </p>
    </div>

  </div>
</section>

<!-- ── STATS ──────────────────────────────────────── -->
<div class="stats-bar">
  <div class="stat">
    <strong>0</strong>
    <span>Asistidos</span>
  </div>
  <div class="stat-divider"></div>
  <div class="stat">
    <strong>0</strong>
    <span>Seguidores</span>
  </div>
  <div class="stat-divider"></div>
  <div class="stat">
    <strong>0</strong>
    <span>Seguidos</span>
  </div>
</div>

<!-- ── CONTENIDO ──────────────────────────────────── -->
<div class="content-layout">

  <!-- POSTS -->
  <div class="posts-section">
    <nav class="profile-tabs">
      <a class="active" href="#">Publicaciones</a>
      <a href="#">Intereses</a>
      <a href="#">Reseñas</a>
    </nav>

    <div class="posts-grid">
      <article><img src="recursos/photo.png" alt="Post 1"></article>
      <article><img src="recursos/photo.png" alt="Post 2"></article>
      <article><img src="recursos/photo.png" alt="Post 3"></article>
      <article><img src="recursos/photo.png" alt="Post 4"></article>
      <article><img src="recursos/photo.png" alt="Post 5"></article>
      <article><img src="recursos/photo.png" alt="Post 6"></article>
    </div>
  </div>

  <!-- PANEL LATERAL -->
  <aside class="side-panel">
    <div class="panel-card">
      <h3>Próximo evento</h3>
      <div class="panel-img">
        <img src="recursos/photo.png" alt="Próximo evento">
      </div>
    </div>
    <div class="panel-card">
      <h3>Último seguidor</h3>
      <div class="panel-user">@tagusuario</div>
    </div>
    <div class="panel-card">
      <h3>Mejor reseña</h3>
      <div class="panel-img">
        <img src="recursos/photo.png" alt="Mejor reseña">
      </div>
    </div>
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2): ?>
    <a href="crearEvento.php" class="crear-event-btn">+ Crear evento</a>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2): ?>
    <a href="editarEvento.php" class="editar-event-btn">✏️ Modificar evento</a>
<?php endif; ?>
  </aside>

</div>

<!-- ── FOOTER ─────────────────────────────────────── -->
<footer class="footer">
  <div class="footer-inner">
    <img class="footer-logo-img" src="recursos/logo.png" alt="SPARK">
    <p class="footer-tagline">Plans, people, memories.</p>
    <nav class="footer-nav">
      <a href="https://www.instagram.com" target="_blank">Instagram</a>
      <a href="https://www.tiktok.com" target="_blank">TikTok</a>
      <a href="tipoUsuario.php">Organizar</a>
    </nav>
    <p class="footer-copy">© <?= date('Y') ?> SPARK · Todos los derechos reservados</p>
  </div>
</footer>

<!-- ── MOBILE NAV ────────────────────────────────── -->
<nav class="mobile-nav">
  <a href="home.php"><span>🏠</span></a>
  <a href="https://www.google.com/maps"><span>📍</span></a>
  <a href="foro.php"><span>💬</span></a>
  <a href="perfil.php"><span>👤</span></a>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(function () {
  $('.profile-tabs a').on('click', function (e) {
    e.preventDefault();
    $('.profile-tabs a').removeClass('active');
    $(this).addClass('active');
  });
});
</script>
<?php include 'layout-bottom.php'; ?>