define(['jquery', 'review-form'], function ($, initForm) {

  var username = $('head').data('username');
  var reviewForm = $('.review-form');

  initForm(reviewForm, {}, function () {
    location.href = '/' + username + '/activity';
  });

});