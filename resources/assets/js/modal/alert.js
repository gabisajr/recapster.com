define(['jquery'], function ($) {

  var alert = $('#alert-message')
    , closeDelay = 2000;

  function open(params) {
    params = params || {};

    if (params.level) alert.attr('class', 'alert alert-' + params.level);
    if (params.message) alert.text(params.message);

    alert.show();

    var delay = params.closeDelay || closeDelay;
    setTimeout(function () {
      alert.addClass('-hide');
      setTimeout(function () { alert.hide().removeClass('-hide') }, 300);
    }, delay);
  }

  function openSuccess(message) {
    return open({level: 'success', message: message});
  }

  function openError(message) {
    return open({level: 'error', message: message});
  }

  function openWarning(message) {
    return open({level: 'warning', message: message});
  }

  function openInfo(message) {
    return open({level: 'info', message: message});
  }

  //если alert пришел с сервера
  $(document).ready(function () {
    if (alert.data('show')) open();
  });

  return {
    success: openSuccess,
    error: openError,
    warning: openWarning,
    info: openInfo
  };

});