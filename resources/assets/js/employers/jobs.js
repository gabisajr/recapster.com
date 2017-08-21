require(['/js/common.js'], function () {

  require(['jquery', 'i18n', 'modal/confirm'], function ($, __, confirm) {

    //<editor-fold desc="Удаление вакансии">
    $(document).on('click', '.delete-job', function (e) {
      e.preventDefault();

      var _this = $(this);
      var id = _this.data('id');
      if (!id) return;

      var message = '<h2 class="no-marg-top">' + __('Удалить вакансию...') + '</h2>'
        + '<p>' + __('Вы уверены что хотите удалить эту вакансию?') + '</p>';

      confirm(message, function (res) {
        if (res) {
          var url = '/job/remove/' + id;
          $('<form method="post" action="' + url + '"></form>').submit();
        }
      });

    });
    //</editor-fold>

  });

});