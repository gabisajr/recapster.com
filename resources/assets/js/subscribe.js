define(['jquery', 'i18n'], function ($, __) {

  //подписаться на компанию или пользователя
  $(document).on('click', '.btn-subscribe', function (e) {
    e.preventDefault();
    var btn = $(this)
      , type = btn.hasClass('btn-subscribe-company') ? 'company' : (btn.hasClass('btn-subscribe-user') ? 'user' : null)
      , id = btn.data('id');

    $.ajax({
      url: '/subscribe',
      type: 'post',
      data: {
        type: type,
        id: id
      },
      beforeSend: function () {
        btn.prop('disabled', true);
      },
      complete: function () {
        btn.prop('disabled', false);
      },
      success: function (res) {
        if (res.success) {
          res.subscribed ? btn.text(__('Вы подписаны')).addClass('btn-success') : btn.text(__('Подписаться')).removeClass('btn-success');
        } else if (res.code == 401) {
          require(['modal/signin'], function (signin) { signin() });
        } else {
          var errMessage = res.message || __('Неизвестная ошибка');
          require(['modal/alert'], function (alert) { alert.error(errMessage) })
        }
      }
    });
  });

});