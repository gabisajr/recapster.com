define(['jquery', 'bootstrap'], function ($) {

  var $confirmModal = $('#confirm-modal')
    , $btnOk = $confirmModal.find('button[name="ok"]');

  window.confirmModal = function (html, yesCallback) {
    $confirmModal.find('.modal-body').html(html);
    $confirmModal.modal();

    if (yesCallback) {
      $btnOk.off();
      $btnOk.click(function () {
        yesCallback();
        $confirmModal.modal('hide');
      });
    }
  };

});