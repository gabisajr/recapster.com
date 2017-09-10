import $ from 'jquery';

console.log('modal');

$(document).on('click', '.close-modal', function () {
  $.fancybox.close();
});

export default {
  close: '<button class="btn-modal-close" title="' + __('Закрыть (Esc)') + '"><i class="icon modal-close">×</i></button>'
};