define(['jquery', 'i18n', 'user/aside'], function ($, __) {

  //приветствие нового пользователя
  if ($('.user-profile').data('show-welcome')) requirejs(['modal/welcome']);

  //показать все подписки пользователя
  $('.user-subscriptions').on('click', '.more', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).closest('.user-subscriptions').find('.post-list-col.hidden').removeClass('hidden');
    $(this).remove();
  });

  //развернуть длиный текст
  $('.edu-post').on('click', '.more', function (e) {
    e.preventDefault();
    var desc = $(this).closest('.post-desc')
      , short = desc.find('.short')
      , full = desc.find('.full');
    short.remove();
    full.show();
  });

  //звездочки отзывов
  requirejs(['bootstrap-star-rating'], function () {
    $('.edu-post .review-rating').rating();
  });

  //предложить заполнить профиль
  $('.btn-profile-offer').click(function (e) {
    e.preventDefault();

    var btn = $(this);

    $.ajax({
      url: '/user/profileOffer',
      data: btn.data(),
      type: 'post',
      beforeSend: function () {
        btn.prop('disabled', true);
      },
      success: function (res) {
        if (res.success) {
          btn.replaceWith('<p class="text-center lima"><i class="fa fa-check"></i> ' + __('Предложение отправлено') + '</p>')
        } else if (res.code === 401) {
          requirejs(['modal/signin'], function (signin) { signin() });
        } else {
          requirejs(['modal/alert'], function (alert) {
            var message = res.error || __('Неизвестная ошибка');
            alert.error(message);
          })
        }
      }
    });
  });

});