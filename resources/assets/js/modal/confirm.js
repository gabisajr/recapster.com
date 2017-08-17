/** confirm modal */
define(['jquery', 'tplModalClose', 'fancybox'], function ($, tplModalClose) {

  var $modal = $('#confirm-modal');
  if (!$modal.length) return;

  var $open = $('.open-confirm-modal').fancybox({
    padding: 0,
    fitToView: false,
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: tplModalClose}
  });

  var callback;

  $modal.find('button[name="ok"]').click(function (e) {
    e.preventDefault();
    callback && callback(true);
  });

  $modal.find('button[name="no"]').click(function (e) {
    e.preventDefault();
    callback && callback(false);
  });

  return function (message) {
    callback = arguments[1];
    $modal.find('.confirm-message').html(message);
    $open.click();
  }

});