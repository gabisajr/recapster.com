define(['jquery', 'post/job'], function ($) {

  $('.job-post').jobPost();


  $('.search-form').each(function () {
    var form = $(this)
      , typeRadio = form.find('input[name="type"]');

    typeRadio.change(function () {
      var radio = typeRadio.filter(':checked')
        , title = radio.data('title')
        , placeholder = radio.data('placeholder');
      form.find('.dropdown.type .title').text(title);
      form.find('input[name=q]').attr('placeholder', placeholder);
    }).filter(':checked').trigger('change'); 

  });

  if ($('.aside-socials').is(':visible')) {
    require([
      'social/share-list',
      'facebook',
      'social/vk-group',
      'lightwidget',
      'twitter-wjs'
    ]);
  }

});