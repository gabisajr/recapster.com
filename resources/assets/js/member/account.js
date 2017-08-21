require(['/js/common.js'], function () {

  require(['jquery'], function ($) {

    //<editor-fold desc="Переключение формы 'Сменить Email'">
    $('.show-form[data-target="#change-email-form"]').click(function () {
      setTimeout(function () {
        $('#change-email-form').find('input[name="new_email"]').focus();
      }, 0)
    });
    //</editor-fold>

  });

  require(['modal/remove-account']);

});