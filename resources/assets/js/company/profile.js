define(['jquery', 'modal/media-viewer', './parallax-cover.js', 'fast-image-upload', './aside.js', 'post/review'], function ($, mediaViewer) {

  //фотографии на профиле компани
  (function (images) {
    if (!images.length) return;
    var data = JSON.parse(images.find('.gallery-json').html());
    images.find('.bubble-image').click(function () {
      mediaViewer.open(this, data, {
        index: $(this).data('index'),
        container: images
      });
    });
  })($('.profile-images'));


  (function () {
    var lastReview = $('.last-review')
      , reviewForm = $('.review-form');

    $('.review-post').reviewPost({afterDelete: afterDeleteReview});

    //удаление отзыва
    function afterDeleteReview() {
      lastReview.hide();
      reviewForm.show();
      reviewForm.find(':input#text').focus();
    }

    //добвление отзыва
    if (reviewForm.length) {
      require(['review-form', 'i18n'], function (initForm, __) {
        initForm(reviewForm, {}, function (review) {
          review = $(review).reviewPost({afterDelete: afterDeleteReview});
          reviewForm.hide();
          lastReview.find('.review-post').remove();
          lastReview.removeClass('hidden').show().find('.panel-header-title').text(__('Ваш отзыв'));
          review.hide().appendTo(lastReview).fadeIn();
        });
      });
    }
  })();

  require(['swipe-tabs']);

});