/** Кнопка 'Хочу работать здесь' */
define(['jquery', 'showSigninModal', 'i18n'], function ($, showSigninModal, __) {

  $('.btn-want-work-here').click(function () {
    var $btn = $(this);

    $btn.hasClass('active') ? off($btn) : on($btn);

    $.ajax({
      url: '/wantworkhere',
      type: 'post',
      data: {id: $(this).data('id')},
      success: function (res) {

        if (res.success) {

          res.has ? on($btn) : off($btn);

          if (res.caption && res.has && res.count > 1) {
            $btn.find('.caption').text(res.caption);
          } else {
            $btn.find('.caption').text(__('Хочу тут работать'));
          }

        } else {

          if (res.code == 401) {
            showSigninModal();
            off($btn);
          } else {
            console.log('Unknown error');
          }

        }

      }
    })

  });

  function on($btn) {
    $btn.addClass('active green accent-4').removeClass('grey lighten-4');
    $btn.find('i').removeClass('fa-heart-o').addClass('fa-heart');
  }

  function off($btn) {
    $btn.removeClass('active green accent-4').addClass('grey lighten-4');
    $btn.find('i').removeClass('fa-heart').addClass('fa-heart-o');
  }

});