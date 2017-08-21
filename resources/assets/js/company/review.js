define(['jquery', 'helpful', 'bootstrap-star-rating', './aside.js'], function ($) {


  $('.page-post .review-rating').rating(); //звездочки отзыва

  //пожаловаться на отзыв
  $('.page-post .report-review').click(function () {
    var id = $(this).data('id');
    if ($('body').data('logged')) {
      require(['modal/complain'], function (open) { open('review', id) });
    } else {
      require(['modal/signin'], function (signin) { signin() });
    }
  });

  //показать всех кому понравился отзыв
  $('.liked-users').each(function () {

    var more = $(this).find('.more')
      , hiddenUsers = $(this).find('.liked-user.hidden');

    more.click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      hiddenUsers.removeClass('hidden');
      $(this).remove();
    });

  });

});