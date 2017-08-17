/** модалка заявки кандидата на работу */
define([
  'jquery',
  'tplModalClose',
  'autosize',
  'fancybox'
], function ($, tplModalClose, autosize) {

  $(document).on('change', 'form#job-apply-answer-form input[name="status"]', function () {
    var $this = $(this)
      , tmpl = $this.siblings('.response-tmpl').text()
      , $form = $this.closest('form');

    var $response = $form.find('.write-message').show()
      .find(':input[name="response"]')
      .val(tmpl)
      .focus();

    autosize($response);
    autosize.update($response);

    $.fancybox.update();
  });

  var modalParams = {
    type: 'ajax',
    padding: 0,
    scrolling: 'hidden',
    fitToView: false,
    margin: [20, 60, 20, 60],
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: tplModalClose}
  };


  return function (data, $tbl) {
    var params = $.extend({}, modalParams, {
      href: '/employers/jobApplication/modal/' + data.id,
      afterClose: function () {
        if ($tbl) {
          $tbl.find('tr.application-data[data-id="' + data.id + '"]')
            .removeClass('unread')
            .find('.icon.envelope').remove();
        }
      }
    });
    $.fancybox.open(data, params);
  };

});