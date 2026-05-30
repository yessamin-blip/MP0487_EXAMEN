<?php
session_start();

require_once __DIR__ . '/../Controller1/eventController.php';
$eventController = new EventController();
$eventos = $eventController->getEvents();

$page_title = 'SPARK · Home';
$page_css   = 'home.css';
include 'layout-top.php';
?>

<div class="hero-banner">

  <div class="slider">
    <img src="recursos/banner.png" alt="" class="slide active">
    <img src="recursos/banner2.png" alt="" class="slide">
    <img src="recursos/banner3.png" alt="" class="slide">
  </div>

  <header class="topbar">
    <a href="home.php" class="nav-logo">
      <img src="recursos/logo.png" alt="SPARK">
    </a>
    <nav class="menu">
      <a href="home.php">Home</a>
      <a href="https://www.google.com/maps">Mapa</a>
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
        <option>Ingles</option>
        <option>Catalan</option>
      </select>
    </div>
    <div class="lang-mobile">
      <input type="checkbox" id="toggleLang">
      <label for="toggleLang" class="icon">🌐</label>
      <ul class="menu-idioma">
        <li>English</li>
        <li>Català</li>
        <li>Español</li>
      </ul>
    </div>
  </header>

</div>

<!-- MARQUEE -->
<div class="marquee-strip">
  <div class="marquee-track">
    <span>Música ✦</span><span>Nightlife ✦</span><span>Rooftop ✦</span><span>Arte ✦</span>
    <span>Pop-up ✦</span><span>Gastronomía ✦</span><span>Deporte ✦</span><span>Social ✦</span>
    <span>Música ✦</span><span>Nightlife ✦</span><span>Rooftop ✦</span><span>Arte ✦</span>
    <span>Pop-up ✦</span><span>Gastronomía ✦</span><span>Deporte ✦</span><span>Social ✦</span>
    <span>Música ✦</span><span>Nightlife ✦</span><span>Rooftop ✦</span><span>Arte ✦</span>
    <span>Pop-up ✦</span><span>Gastronomía ✦</span><span>Deporte ✦</span><span>Social ✦</span>
  </div>
</div>

<!-- EVENTOS DESTACADOS -->
<section class="section-events" id="eventos">
  <div class="section-header">
    <div>
      <p class="section-label">Esta semana</p>
      <h2 class="section-title">DESTACADOS</h2>
    </div>
    <a href="eventos.php" class="see-all">Ver todos →</a>
  </div>

  <div class="events-grid">
    <?php
    $gradients = ['ev-g1 ev-card--big', 'ev-g2', 'ev-g3', 'ev-g4'];
    if (!empty($eventos) && is_array($eventos)):
      foreach ($eventos as $i => $ev):
        if ($i >= 4) break;
        $grad = $gradients[$i] ?? 'ev-g1';
    ?>
        <article class="ev-card <?= $grad ?>">
          <div class="ev-overlay"></div>
          <div class="ev-hover-msg">🎟 Ver detalles del evento</div>
          <div class="ev-body">
            <div class="ev-meta-top">
              <span class="ev-cat">Evento</span>
              <span class="ev-price">Ver</span>
            </div>
            <h3 class="ev-title"><?= htmlspecialchars($ev['Nombre_evento']) ?></h3>
            <div class="ev-meta-bottom">
              <span class="ev-venue">📍 <?= htmlspecialchars($ev['Ubicacion']) ?></span>
              <span class="ev-date"><?= date('D, M d', strtotime($ev['Fecha_evento'])) ?></span>
            </div>
            <a href="evento.php?id=<?= $ev['Id_Evento'] ?>" class="ev-btn">Reservar</a>
          </div>
        </article>
      <?php
      endforeach;
    else:
      ?>
      <article class="ev-card ev-g1 ev-card--big">
        <div class="ev-overlay"></div>
        <div class="ev-hover-msg">🎟 Ver detalles del evento</div>
        <div class="ev-body">
          <div class="ev-meta-top">
            <span class="ev-cat">Nightlife</span>
            <span class="ev-price">€18</span>
          </div>
          <h3 class="ev-title">Noche Electrónica</h3>
          <div class="ev-meta-bottom">
            <span class="ev-venue">📍 Paral·lel</span>
            <span class="ev-date">Vie, May 10 · 23:00</span>
          </div>
          <a href="evento.php" class="ev-btn">Reservar</a>
        </div>
      </article>
      <article class="ev-card ev-g2">
        <div class="ev-overlay"></div>
        <div class="ev-hover-msg">🎟 Ver detalles del evento</div>
        <div class="ev-body">
          <div class="ev-meta-top">
            <span class="ev-cat">Pop-up</span>
            <span class="ev-price">€35</span>
          </div>
          <h3 class="ev-title">Pop-up Raval</h3>
          <div class="ev-meta-bottom">
            <span class="ev-venue">📍 Raval</span>
            <span class="ev-date">Sáb, May 11 · 13:00</span>
          </div>
          <a href="evento.php" class="ev-btn">Reservar</a>
        </div>
      </article>
      <article class="ev-card ev-g3">
        <div class="ev-overlay"></div>
        <div class="ev-hover-msg">🎟 Ver detalles del evento</div>
        <div class="ev-body">
          <div class="ev-meta-top">
            <span class="ev-cat">Rooftop</span>
            <span class="ev-price">€22</span>
          </div>
          <h3 class="ev-title">Sunset Barceloneta</h3>
          <div class="ev-meta-bottom">
            <span class="ev-venue">📍 Barceloneta</span>
            <span class="ev-date">Sáb, May 11 · 19:30</span>
          </div>
          <a href="evento.php" class="ev-btn">Reservar</a>
        </div>
      </article>
      <article class="ev-card ev-g4">
        <div class="ev-overlay"></div>
        <div class="ev-hover-msg">🎟 Ver detalles del evento</div>
        <div class="ev-body">
          <div class="ev-meta-top">
            <span class="ev-cat">Arte</span>
            <span class="ev-price free">Gratis</span>
          </div>
          <h3 class="ev-title">Galería Nuit</h3>
          <div class="ev-meta-bottom">
            <span class="ev-venue">📍 Eixample</span>
            <span class="ev-date">Dom, May 12 · 19:00</span>
          </div>
          <a href="evento.php" class="ev-btn">Reservar</a>
        </div>
      </article>
    <?php endif; ?>
  </div>
</section>

<!-- BÚSQUEDA + FILTROS -->
<section class="section-search" id="todos">
  <div class="search-inner">
    <h2 class="search-title">¿QUÉ PLAN TIENES?</h2>
    <div class="search-bar-wrap">
      <input type="search" class="search-input" placeholder="Buscar eventos, barrios, artistas…" id="searchInput">
      <button class="search-btn">→</button>
    </div>
    <div class="filter-chips" id="filterChips">
      <button class="chip active" data-cat="">Todo</button>
      <button class="chip" data-cat="nightlife">Nightlife</button>
      <button class="chip" data-cat="musica">Música</button>
      <button class="chip" data-cat="rooftop">Rooftop</button>
      <button class="chip" data-cat="arte">Arte</button>
      <button class="chip" data-cat="gastronomia">Gastro</button>
      <button class="chip" data-cat="popup">Pop-up</button>
      <button class="chip" data-cat="deporte">Deporte</button>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <img class="logo" src="recursos/logo.png" alt="SPARK">
    <p class="footer-tagline">Plans, people, memories.</p>
    <nav class="footer-nav">
      <a href="https://www.instagram.com" target="_blank">Instagram</a>
      <a href="https://www.tiktok.com" target="_blank">Tiktok</a>
      <a href="tipoUsuario.php">Organizar</a>
    </nav>
    <p class="footer-copy">© <?= date('Y') ?> SPARK · Todos los derechos reservados</p>
  </div>
</footer>
<!-- SLIDER CONCIERTOS -->
<section class="section-sliders">
  <div class="slider-section-header">
    <p class="section-label">En directo</p>
    <h2 class="section-title">PRÓXIMOS CONCIERTOS</h2>
  </div>
  <div class="slider-concerts">
    <div class="slider-item">
      <div class="slider-img" style="background-image:url('recursos/dj.jpg')"></div>
      <div class="slider-info">
        <span class="slider-cat">Nightlife</span>
        <h3>Noche Electrónica</h3>
        <p>📍 Paral·lel · Vie, May 10 · 23:00</p>
      </div>
    </div>
    <div class="slider-item">
      <div class="slider-img" style="background-image:url('recursos/sunset.jpg')"></div>
      <div class="slider-info">
        <span class="slider-cat">Rooftop</span>
        <h3>Sunset Barceloneta</h3>
        <p>📍 Barceloneta · Sáb, May 11 · 19:30</p>
      </div>
    </div>
    <div class="slider-item">
      <div class="slider-img" style="background-image:url('recursos/galeria.jpg')"></div>
      <div class="slider-info">
        <span class="slider-cat">Arte</span>
        <h3>Galería Nuit</h3>
        <p>📍 Eixample · Dom, May 12 · 19:00</p>
      </div>
    </div>
    <div class="slider-item">
      <div class="slider-img" style="background-image:url('recursos/popUp.jpg')"></div>
      <div class="slider-info">
        <span class="slider-cat">Pop-up</span>
        <h3>Pop-up Raval</h3>
        <p>📍 Raval · Sáb, May 11 · 13:00</p>
      </div>
    </div>
  </div>
</section>

<!-- SLIDER PROMOTORES -->
<section class="section-sliders section-sliders--dark">
  <div class="slider-section-header">
    <p class="section-label" style="color:rgba(255,255,255,.5)">Quiénes hay detrás</p>
    <h2 class="section-title" style="color:#E8D48A">PROMOTORES</h2>
  </div>
  <div class="slider-promoters">
    <div class="slider-promo-item">
      <div class="promo-avatar">BN</div>
      <h3 class="promo-name">Barcelona Nights</h3>
      <p class="promo-desc">Especialistas en eventos de música electrónica y cultura urbana desde 2015.</p>
      <span class="promo-tag">+40 eventos</span>
    </div>
    <div class="slider-promo-item">
      <div class="promo-avatar">SR</div>
      <h3 class="promo-name">Sunset Rooftop</h3>
      <p class="promo-desc">Experiencias únicas en azoteas con vistas panorámicas a la ciudad.</p>
      <span class="promo-tag">+18 eventos</span>
    </div>
    <div class="slider-promo-item">
      <div class="promo-avatar">AC</div>
      <h3 class="promo-name">Arte & Cultura</h3>
      <p class="promo-desc">Galerías, pop-ups y experiencias artísticas en los mejores espacios de Barcelona.</p>
      <span class="promo-tag">+25 eventos</span>
    </div>
    <div class="slider-promo-item">
      <div class="promo-avatar">GF</div>
      <h3 class="promo-name">Gastro Fest</h3>
      <p class="promo-desc">Mercados gastronómicos y experiencias culinarias de primer nivel.</p>
      <span class="promo-tag">+12 eventos</span>
    </div>
  </div>
</section>
<!-- NAVBAR MÓVIL -->
<nav class="mobile-nav">
  <a href="home.php"><span>🏠</span></a>
  <a href="https://www.google.com/maps"><span>📍</span></a>
  <a href="foro.php"><span>💬</span></a>
  <a href="perfil.php"><span>👤</span></a>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="JS/home.js"></script>

<?php include 'layout-bottom.php'; ?>