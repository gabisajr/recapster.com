define(['jquery', './aside.js', 'post/review', 'post/image'], function ($) {

  var addForm = $('form#add-form')
    , activityList = $('.activity-list');

  activityList.find('.images-post').imagePost();
  activityList.find('.review-post').reviewPost();

  if (addForm.length) require(['add-form'], function (initForm) {
    initForm(addForm, function (html) {
      if (html) {
        activityList.find('.gag').remove();
        var item = $(html);
        item.find('.images-post').imagePost();
        item.find('.review-post').reviewPost();
        item.hide().prependTo(activityList).fadeIn();
      }
    });
  });

});