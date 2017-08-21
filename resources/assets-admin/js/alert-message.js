define(['jquery'], function ($) {

  var alert_messages = $('.alert-messages')
    , primary = alert_messages.find('.bg-primary')
    , success = alert_messages.find('.bg-success')
    , info = alert_messages.find('.bg-info')
    , warning = alert_messages.find('.bg-warning')
    , danger = alert_messages.find('.bg-danger')
    , hideInterval = 3000;

  setTimeout(function () {
    alert_messages.find('p').fadeOut();
  }, hideInterval);

  window.alertMessage = function (text, level) {
    var block;
    switch (level) {
      case 'primary':
        block = primary;
        break;
      case 'success':
        block = success;
        break;
      case 'info':
        block = info;
        break;
      case 'warning':
        block = warning;
        break;
      case 'danger':
      case 'error':
        block = danger;
        break;
    }

    $('body').scrollTop(0);
    block.find('span.text').text(text);
    block.fadeIn();

    setTimeout(function () {
      block.find('.close').click();
    }, hideInterval);
  };

  alert_messages.find('.close').click(function () {
    $(this).closest('p').fadeOut();
  });
});