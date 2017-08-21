define(['jquery', 'i18n'], function ($, __) {

  // console.log('modal');

  $(document).on('click', '.close-modal', function () {
    $.fancybox.close();
  });

  return {
    close: '<button class="btn-modal-close" title="' + __('Закрыть (Esc)') + '"><i class="icon modal-close">×</i></button>'
  }
});