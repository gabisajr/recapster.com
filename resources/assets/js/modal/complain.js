import $ from 'jquery';
// define(['jquery', 'modal', 'i18n', 'autosize', 'modal/alert', 'fancybox'], function ($, modal, __, autosize, alert) {
//
// });

let form, message;

function open(type, id) {

  let params = $.param([
    {name: 'id', value: id},
    {name: 'type', value: type}
  ]);

  $.fancybox.open({
    type: 'ajax',
    padding: 0,
    tpl: {closeBtn: modal.close},
    helpers: {
      overlay: {locked: false}
    },
    src: '/claim/modal?' + params,
    beforeShow: function () {
      form = $('form#complain-form');
      message = form.find(':input[name="message"]');
      form.submit(onsubmit);
      autosize(message);
      message.on('autosize:resized', function () { $.fancybox.update() });
    },
    afterShow: function () {
      message.focus();
    }
  });
}

function onsubmit(e) {
  e.preventDefault();

  let btnSubmit = $(this).find('[type="submit"]');

  $.ajax({
    url: this.action,
    type: this.method,
    data: $(this).serialize(),
    beforeSend: function () {
      btnSubmit.prop('disabled', true);
    },
    complete: function () {
      btnSubmit.prop('disabled', false);
      $.fancybox.close();
    },
    success: function (res) {
      if (res.success) {
        alert.success(__('Ваша жалоба принята'));
      } else {
        alert.error(__('Не удалось отправить жалобу'));
      }
    }
  });
}


export default open;