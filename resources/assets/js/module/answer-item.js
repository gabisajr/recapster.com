/** голосование за ответ */
define(['jquery', 'showMessageModal', 'i18n'], function ($, showMessageModal, __) {

  $(document).on('click', '.answer-item .btn-rating', function (e) {
    e.preventDefault();

    var $btn = $(this);

    $.post('/interview/voteQuestionAnswer', $btn.data(), function (data) {

      data = data || {};

      if (data.success) {

        var $rating = $btn.closest('.top-down-rating')
          , $amount = $rating.find('.amount')
          , $up = $rating.find('.btn-rating-up')
          , $down = $rating.find('.btn-rating-down');

        $amount.text(data.count);

        var flag = data['flag'];

        if (flag == 'up') {
          $up.removeClass('light-blue darken-2').addClass('green accent-4');
        } else {
          $up.addClass('light-blue darken-2').removeClass('green accent-4');
        }

        if (flag == 'down') {
          $down.removeClass('light-blue darken-2').addClass('red lighten-1');
        } else {
          $down.addClass('light-blue darken-2').removeClass('red lighten-1');
        }

        $up.prop('disabled', true);
        $down.prop('disabled', true);

      } else {
        if (data.code == 'ALREADY_VOTED') return already_voted();
        else if (data.code == 401) {
          $('.open-login-modal').click();
        } else {
          console.log('Неизвестная ошибка');
        }
      }

    });

  });

  $(document).on('click', '.answer-item .top-down-rating', function () {
    if ($(this).find('.btn-rating:disabled').length) already_voted()
  });

  function already_voted() {
    showMessageModal(__('Вы можете только 1 раз голосовать за данный ответ'), __('Вы уже голосовали'));
  }

});