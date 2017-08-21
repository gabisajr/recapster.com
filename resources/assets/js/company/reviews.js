define(['jquery', './parallax-cover.js', './aside.js', 'post/review'], function ($) {

  $('.review-post').reviewPost();

  //добавление отзыва
  var reviewForm = $('.review-form');
  if (reviewForm.length) require(['review-form', 'i18n'], function (initForm) {
    initForm(reviewForm, {}, function () { window.location.reload() });
  });

  require(['swipe-tabs']);

});