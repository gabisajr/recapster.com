define('showMessageModal', ['jquery', 'tplModalClose', 'fancybox'], function ($, tplModalClose) {

  var $modal = $('.modal#message-modal');

  var $open = $('.open-message-modal').fancybox({
    padding: 0,
    fitToView: false,
    closeBtn: true,
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: tplModalClose}
  });

  function showMessageModal(message, title) {
    if (!message) return;

    if (title) {
      $modal.find('.modal-header').show().find('.modal-title').text(title);
    } else {
      $modal.find('.modal-header').hide();
    }

    $modal.find('.message').html(message);

    $open.click();
  }

  //показать модально окно с сообщением сразу, если пришло с сервера
  $(document).ready(function () {
    var title = $modal.find('.modal-header .modal-title').text()
      , message = $modal.find('.message').html();

    if (message) showMessageModal(message, title);
  });

  return showMessageModal;

});