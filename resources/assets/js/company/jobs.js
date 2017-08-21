define(['jquery', './parallax-cover.js', './aside.js', 'post/job'], function ($) {

  $('.job-post').jobPost();

  require(['swipe-tabs']);

});