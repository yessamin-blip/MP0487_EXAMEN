$(function() {

  // ── Slider hero ──────────────────────────────────
  let current = 0;
  const slides = $('.slide');
  const total = slides.length;

  setInterval(function() {
    slides.eq(current).removeClass('active');
    current = (current + 1) % total;
    slides.eq(current).addClass('active');
  }, 4000);

  // ── Hover message en tarjetas ─────────────────────
  $('.ev-card').on('mouseenter', function() {
    $(this).find('.ev-hover-msg').stop(true).fadeIn(200);
  }).on('mouseleave', function() {
    $(this).find('.ev-hover-msg').stop(true).fadeOut(200);
  });

  // ── Filtros categoría ─────────────────────────────
  $('#filterChips .chip').on('click', function() {
    $('#filterChips .chip').removeClass('active');
    $(this).addClass('active');
  });

  // ── Búsqueda ──────────────────────────────────────
  $('#searchInput').on('input', function() {
    const q = $(this).val().toLowerCase().trim();
    if (!q) return;
    $('html, body').animate({ scrollTop: $('#todos').offset().top - 80 }, 300);
  });

  // ── Slick: conciertos ─────────────────────────────
  $('.slider-concerts').slick({
    dots: true,
    infinite: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: { slidesToShow: 2, slidesToScroll: 1 }
      },
      {
        breakpoint: 600,
        settings: { slidesToShow: 1, slidesToScroll: 1, arrows: false }
      }
    ]
  });

  // ── Slick: promotores ─────────────────────────────
  $('.slider-promoters').slick({
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 3500,
    speed: 600,
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: true,
        responsive: [
      {
        breakpoint: 1024,
        settings: { slidesToShow: 2, slidesToScroll: 1, dots: true, arrows: false }
      },
      {
        breakpoint: 600,
        settings: { slidesToShow: 1, slidesToScroll: 1, arrows: false, dots: true }
      }
    ]
  });

});