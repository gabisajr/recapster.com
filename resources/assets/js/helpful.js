/** Кнопка 'Полезно' */
define(['jquery', 'modal/signin', 'i18n'], function ($, signin, __) {

  $(document).on('click', '.btn-helpful', function (e) {

    e.preventDefault();
    e.stopPropagation();

    var $btn = $(this)
      , $count = $btn.find('.count');

    $.ajax({
      url: '/helpful',
      method: 'post',
      data: $btn.data(),
      success: function (res) {

        if (res.success) {

          //btn color
          if (res.exists) {
            $btn.addClass('btn-success').removeClass('btn-default');
          } else {
            $btn.addClass('btn-default').removeClass('btn-success');
          }

          //counter
          $count.text(res.value);
          if (res.value) {
            $count.removeClass('hidden');
          } else {
            $count.addClass('hidden');
          }

        } else {

          if (res.code == 401) {
            signin();
          } else {
            console.log(__('Неизвестная ошибка'));
          }
        }
      }
    })
  });
});