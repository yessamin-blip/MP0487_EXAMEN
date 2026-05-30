/* ═══════════════════════════════════════════
   SPARK · cookies.js  —  localStorage + jQuery
═══════════════════════════════════════════ */

function mostrarBanner() {
  $('#cookieOverlay').fadeIn(300);
  $('#cookieBanner').fadeIn(400);
}

function cerrarBanner() {
  $('#cookieBanner').fadeOut(300);
  $('#cookieOverlay').fadeOut(300);
}

function cookiesAceptarTodas() {
  localStorage.setItem('spark_cookies',   'todas');
  localStorage.setItem('spark_analitica', 'true');
  localStorage.setItem('spark_marketing', 'true');
  cerrarBanner();
  // Si estamos en login, mostrar el formulario
  $('#loginFormWrap').fadeIn(300);
  $('#cookieGate').hide();
}

function cookiesSoloEsenciales() {
  localStorage.setItem('spark_cookies',   'esenciales');
  localStorage.setItem('spark_analitica', 'false');
  localStorage.setItem('spark_marketing', 'false');
  cerrarBanner();
  $('#loginFormWrap').fadeIn(300);
  $('#cookieGate').hide();
}

function cookiesRechazar() {
  localStorage.removeItem('spark_cookies');
  cerrarBanner();
  // Si estamos en login, mostrar el botón de re-mostrar aviso
  $('#loginFormWrap').hide();
  $('#cookieGate').fadeIn(300);
}

// Al cargar la página: mostrar banner si no ha decidido
$(function() {
  if (!localStorage.getItem('spark_cookies')) {
    mostrarBanner();
  }
});