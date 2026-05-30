<?php
session_start();

require_once __DIR__ . '/../Controller1/eventController.php';
$eventController = new EventController();


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header('Location: eventos.php');
    exit();
}


$ev = $eventController->getEvents($id);


if (!$ev || $ev === 'error_base_datos') {
    header('Location: eventos.php');
    exit();
}


$fechaFormateada = date('D, d M Y', strtotime($ev['Fecha_evento']));
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($ev['Nombre_evento']) ?> · SPARK</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="evento.css">
</head>
<body>

<!-- ── NAV ──────────────────────────────────────── -->
<nav class="nav" id="nav">
  <a href="home.php" class="nav-logo">
    <img src="recursos/logo.png" alt="SPARK">
  </a>
  <ul class="nav-links">
    <li><a href="home.php">Home</a></li>
    <li><a href="https://www.google.com/maps" target="_blank">Mapa</a></li>
    <li><a href="foro.php">Foro</a></li>
  </ul>
  <div class="nav-actions">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="perfil.php" class="nav-btn-ghost">Perfil</a>
      <a href="logout.php" class="nav-btn-pill">Cerrar sesión</a>
    <?php else: ?>
      <a href="login.php" class="nav-btn-pill">Log in / Sign up</a>
    <?php endif; ?>
    <select class="lang-sel">
      <option>Español</option>
      <option>English</option>
      <option>Català</option>
    </select>
  </div>
</nav>

<!-- ── HERO ─────────────────────────────────────── -->
<section class="ev-hero">
  <img class="ev-hero__img" src="recursos/popUp.jpg" alt="Foto del evento">
  <div class="ev-hero__overlay"></div>
  <div class="ev-hero__grain"></div>
  <div class="ev-hero__inner">
    <div class="ev-hero__top">
      <span class="ev-cat">Evento</span>
    </div>
    <h1 class="ev-hero__title"><?= htmlspecialchars($ev['Nombre_evento']) ?></h1>
    <div class="ev-hero__meta">
      <span>📅 <?= $fechaFormateada ?></span>
      <span>📍 <?= htmlspecialchars($ev['Ubicacion']) ?></span>
    </div>
  </div>
</section>

<!-- ── LAYOUT ────────────────────────────────────── -->
<div class="ev-layout">

  <!-- COLUMNA PRINCIPAL -->
  <div class="ev-main">
    <div class="ev-desc">
      <h2 class="ev-desc__title">Sobre el evento</h2>
      <p class="ev-desc__text"><?= htmlspecialchars($ev['Descripcion']) ?></p>
    </div>

    
    <a href="#" class="ev-reserve-btn ev-reserve-btn--mobile">Reservar plaza →</a>
  </div>

  <!-- SIDEBAR -->
  <aside class="ev-sidebar">

    <!-- Reserva -->
    <div class="ev-sidebar__card ev-sidebar__reserve">
      <div class="ev-reserve__price">Reservar</div>
      <p class="ev-reserve__label">plaza para este evento</p>
      <a href="#" class="ev-reserve-btn">Reservar plaza →</a>
      <p class="ev-reserve__note">Sin comisiones ocultas</p>
    </div>

    <!-- Organizador -->
    <div class="ev-sidebar__card">
      <div class="ev-org">
        <div class="ev-org__avatar">S</div>
        <div>
          <p class="ev-org__name">SPARK Organizador</p>
          <p class="ev-org__role">Organizador verificado ✓</p>
        </div>
      </div>
      <div class="ev-org__stats">
        <div><strong>10</strong><span>Seguidores</span></div>
        <div><strong>20</strong><span>Eventos</span></div>
      </div>
      <a href="#" class="ev-contact-btn">Contactar</a>
    </div>

    <!-- Detalles -->
    <div class="ev-sidebar__card">
      <ul class="ev-details">
        <li>
          <span>Fecha</span>
          <strong><?= $fechaFormateada ?></strong>
        </li>
        <li>
          <span>Lugar</span>
          <strong><?= htmlspecialchars($ev['Ubicacion']) ?></strong>
        </li>
      </ul>
    </div>

  </aside>
</div>

<!-- ── FOOTER ────────────────────────────────────── -->
<footer class="footer">
  <div class="footer-inner">
    <a href="home.php" class="footer-logo">SP<span>▲</span>RK</a>
    <p class="footer-tagline">Barcelona, siempre.</p>
    <nav class="footer-nav">
      <a href="home.php">Home</a>
      <a href="foro.php">Foro</a>
      <a href="perfil.php">Perfil</a>
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
$(function() {
  $(window).on('scroll', function() {
    $('#nav').toggleClass('nav--scrolled', $(this).scrollTop() > 60);
  });
});
</script>

<?php include 'cookies-banner.php'; ?>
<script src="js/cookies.js"></script>
</body>
</html>