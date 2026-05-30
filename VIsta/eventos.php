<?php
session_start();

require_once __DIR__ . '/../Controller1/eventController.php';
$eventController = new EventController();
$eventos = $eventController->getEvents();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPARK · Todos los eventos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="home.css">
  <style>
    
    .eventos-hero {
      background: var(--beige);
      padding: 120px 48px 60px;
      border-bottom: 1px solid rgba(0,0,0,0.07);
    }
    .eventos-hero__label {
      font-size: 11px;
      font-weight: 500;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--muted, #9A9186);
      margin-bottom: 8px;
    }
    .eventos-hero__title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(52px, 8vw, 100px);
      line-height: .9;
      color: var(--dark);
    }
    .eventos-hero__count {
      font-size: 14px;
      color: var(--muted, #9A9186);
      margin-top: 12px;
    }
    .eventos-hero__count span {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 20px;
      color: var(--butter-d, #C9B660);
    }

    .eventos-page {
      padding: 48px 48px 80px;
      background: var(--beige);
    }

    
    .eventos-filters {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 40px;
    }
    .ev-filter-btn {
      background: rgba(255,255,255,.6);
      border: 1px solid rgba(0,0,0,.1);
      color: var(--dark);
      font-family: 'Poppins', sans-serif;
      font-size: 12px;
      font-weight: 500;
      letter-spacing: .5px;
      padding: 8px 20px;
      border-radius: 99px;
      cursor: pointer;
      transition: all .2s;
    }
    .ev-filter-btn:hover,
    .ev-filter-btn.active {
      background: var(--dark);
      color: var(--butter);
      border-color: var(--dark);
    }

    
    .eventos-grid-full {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }

    
    .eventos-grid-full .ev-card {
      min-height: 320px;
      border-radius: 22px;
    }

    
    .no-eventos {
      text-align: center;
      padding: 80px 20px;
      color: var(--muted, #9A9186);
    }
    .no-eventos h3 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 36px;
      color: var(--dark);
      margin-bottom: 8px;
    }

    @media (max-width: 1024px) {
      .eventos-hero { padding: 100px 28px 48px; }
      .eventos-page { padding: 32px 28px 80px; }
      .eventos-grid-full { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
      .eventos-hero { padding: 90px 16px 40px; }
      .eventos-page { padding: 24px 16px 80px; }
      .eventos-grid-full { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- NAV -->
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
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="perfil.php" class="login">Perfil</a>
      <a href="logout.php" class="login">Cerrar sesión</a>
    <?php else: ?>
      <a href="login.php" class="login">Log in / Sign up</a>
    <?php endif; ?>
    <select id="español">
      <option>Español</option>
      <option>English</option>
      <option>Català</option>
    </select>
  </div>
</header>

<!-- HERO -->
<div class="eventos-hero">
  <p class="eventos-hero__label">Barcelona · 2025</p>
  <h1 class="eventos-hero__title">TODOS LOS<br>EVENTOS</h1>
  <p class="eventos-hero__count">
    <span><?= is_array($eventos) ? count($eventos) : 0 ?></span>
    eventos disponibles
  </p>
</div>

<!-- CONTENIDO -->
<div class="eventos-page">

  <!-- Filtros -->
  <div class="eventos-filters" id="filtros">
    <button class="ev-filter-btn active" data-cat="">Todo</button>
    <button class="ev-filter-btn" data-cat="nightlife">Nightlife</button>
    <button class="ev-filter-btn" data-cat="musica">Música</button>
    <button class="ev-filter-btn" data-cat="rooftop">Rooftop</button>
    <button class="ev-filter-btn" data-cat="arte">Arte</button>
    <button class="ev-filter-btn" data-cat="gastronomia">Gastro</button>
    <button class="ev-filter-btn" data-cat="popup">Pop-up</button>
    <button class="ev-filter-btn" data-cat="deporte">Deporte</button>
  </div>

  <!-- Grid -->
  <?php if (!empty($eventos) && is_array($eventos)): ?>
  <div class="eventos-grid-full" id="eventosGrid">
    <?php
    $gradients = ['ev-g1', 'ev-g2', 'ev-g3', 'ev-g4'];
    foreach ($eventos as $i => $ev):
      $grad = $gradients[$i % 4];
    ?>
    <article class="ev-card <?= $grad ?>" data-cat="">
      <div class="ev-overlay"></div>
      <div class="ev-body">
        <div class="ev-meta-top">
          <span class="ev-cat">Evento</span>
          <span class="ev-price">Ver</span>
        </div>
        <h3 class="ev-title"><?= htmlspecialchars($ev['Nombre_evento']) ?></h3>
        <div class="ev-meta-bottom">
          <span class="ev-venue">📍 <?= htmlspecialchars($ev['Ubicacion']) ?></span>
          <span class="ev-date">
            <?= date('D, M d', strtotime($ev['Fecha_evento'])) ?>
          </span>
        </div>
        <a href="evento.php?id=<?= $ev['Id_Evento'] ?>" class="ev-btn">Ver evento</a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

  <?php else: ?>
  <div class="no-eventos">
    <h3>No hay eventos disponibles</h3>
    <p>Vuelve pronto — Barcelona nunca para.</p>
  </div>
  <?php endif; ?>

</div>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <img class="logo" src="recursos/logo.png" alt="SPARK">
    <p class="footer-tagline">Plans, people, memories.</p>
    <nav class="footer-nav">
      <a href="https://www.instagram.com" target="_blank">Instagram</a>
      <a href="https://www.tiktok.com" target="_blank">TikTok</a>
      <a href="tipoUsuario.php">Organizar</a>
    </nav>
    <p class="footer-copy">© <?= date('Y') ?> SPARK · Todos los derechos reservados</p>
  </div>
</footer>

<!-- MOBILE NAV -->
<nav class="mobile-nav">
  <a href="home.php"><span>🏠</span></a>
  <a href="https://www.google.com/maps"><span>📍</span></a>
  <a href="foro.php"><span>💬</span></a>
  <a href="perfil.php"><span>👤</span></a>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(function() {
 
  $('#filtros .ev-filter-btn').on('click', function() {
    $('#filtros .ev-filter-btn').removeClass('active');
    $(this).addClass('active');

    const cat = $(this).data('cat');
    if (!cat) {
      $('#eventosGrid .ev-card').show();
      return;
    }
    $('#eventosGrid .ev-card').each(function() {
      $(this).data('cat') === cat ? $(this).show() : $(this).hide();
    });
  });
});
</script>

</body>
</html>