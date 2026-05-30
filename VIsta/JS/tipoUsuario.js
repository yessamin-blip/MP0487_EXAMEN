$(function () {
  $('.tipo-opt').on('click', function () {
    $('.tipo-opt').removeClass('active');
    $(this).addClass('active');
    $('#tipoInput').val($(this).data('val'));
  });
});