//<editor-fold desc="Алерты">
$(function () {

  var autoCloseAlert = true
    , autoCloseAlertTime = 3000;

  //закрыть алерт
  $(document).on('click', '.alert .close-alert', function () {
    $(this).closest('.alert').fadeOut(function () {
      $(this).remove();
    });
  });

  //автоматически закрыть алерт
  if (autoCloseAlert) {
    setTimeout(function () {
      $('.alert.alert-autoclose').fadeOut(function () {
        $(this).remove()
      })
    }, autoCloseAlertTime);
  }
});
//</editor-fold>