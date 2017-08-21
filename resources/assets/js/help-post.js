require(['/js/common.js'], function () {

  require(['jquery', 'showSigninModal'], function ($, showSigninModal) {

    /** Голосование за полезность статьи */
    $('button[name="post-helpful"]').click(function (e) {
      e.preventDefault();
      var $btn = $(this);
      var data = $.extend($(this).data(), {helpful: $(this).val()});
      $.post('/helpful', data, function (res) {

        if (res.success) {
          $btn.closest('p').addClass('gray').html('<strong>Спасибо за вашу оценку!</strong>');
        } else if (res.code == 401) {
          showSigninModal();
        } else {
          console.log('unknown error');
        }
      });
    });

  });

});