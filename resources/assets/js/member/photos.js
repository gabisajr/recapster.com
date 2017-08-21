require(['/js/common.js'], function () {

  require(['modal/edit-image']);

  require(['jquery', 'modal/confirm', 'i18n'], function ($, confirm, __) {

    //<editor-fold desc="Удаление фотографии">
    $(document).on('click', '.delete-contribution-image', function (e) {
      e.preventDefault();

      var _this = $(this);
      var imageId = _this.data('imageId');
      if (!imageId) return;

      var message = '<h2 class="no-marg-top">' + __('Удалить фото...') + '</h2>'
        + '<p>' + __('Вы уверены что хотите удалить это фото?') + '</p>';

      confirm(message, function (res) {
        if (res) {
          var url = '/image/remove/' + imageId;
          $('<form method="post" action="' + url + '"></form>').submit();
        }
      });

    });
    //</editor-fold>

  });

});