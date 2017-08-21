define(['jquery', 'i18n', 'social/share-list', './aside.js'], function ($, __) {

  //добавить в избранное
  $('.page-post input[name="fave"]').change(function () {
    var input = $(this)
      , label = input.closest('label')
      , id = input.val();

    $.post('/job/fave/' + id, function (res) {
      if (res.success) {
        input.prop('checked', res.fave);
        label.attr('title', res.fave ? __('Избранная вакансия') : __('Добавить в избранное'));
      } else {
        input.prop('checked', false);
        if (res.code == 401) {
          require(['modal/signin'], function (signin) { signin() })
        } else {
          require(['modal/alert'], function (alert) { alert.error(__('Unknown error')) })
        }
      }
    });
  });

  //показать контакты
  $('.btn-show-contacts').click(function (e) {
    e.preventDefault();
    $(this).remove();
    $('.job-contacts').fadeIn();
  });

});