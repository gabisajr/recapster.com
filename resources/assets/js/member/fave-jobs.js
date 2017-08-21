require(['/js/common.js'], function () {

  require(['jquery', 'i18n'], function ($, __) {

    //<editor-fold desc="удаление вакансии из избранного">
    $(document).on('change', 'table#fave-jobs .fave input[type="checkbox"][name="fave"]', function () {

      var $tooltip = $(this).closest('.tooltips')
        , isFave = $(this).is(':checked')
        , title = isFave ? __('Удалить из избранного') : __('Вернуть в избранное');

      $.powerTip.hide($tooltip);
      $.powerTip.destroy($tooltip);

      $tooltip.attr('title', title).powerTip();
      setTimeout(function () {
        $.powerTip.show($tooltip);
      }, 100);

    });
    //</editor-fold>

  });

});