/* ═══════════════════════════════════════════════════
   SPARK · eliminarEvento.js
   Lógica del modal de confirmación de evento
═══════════════════════════════════════════════════ */

$(function () {

  // Abrir modal
  $('#btnEliminarEvento').on('click', function () {
    $('#modalOverlay').addClass('active');
  });

  // Cerrar — botón cancelar
  $('#modalCancelar').on('click', function () {
    $('#modalOverlay').removeClass('active');
  });

  // Cerrar — clic fuera del modal
  $('#modalOverlay').on('click', function (e) {
    if ($(e.target).is('#modalOverlay')) {
      $(this).removeClass('active');
    }
  });

  // Cerrar — tecla ESC
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      $('#modalOverlay').removeClass('active');
    }
  });

  // Confirmar — enviar formulario
  $('#modalConfirmar').on('click', function () {
    $('#deleteEventoForm').submit();
  });

});
