define(['jquery'], function ($) {

  $('.tabs').each(function () {
    var $tabs = $(this)
      , contentsId = $tabs.data('tabs')
      , $contents = $tabs.siblings('#' + contentsId);

    $tabs.find('.tab').click(function (e) {

      e.preventDefault();

      var $tab = $(this)
        , targetTabId = $tab.data('target');

      if ($tab.hasClass('active')) return;

      $tabs.find('.tab.active').removeClass('active');
      $tab.addClass('active');

      $contents.find('.tab-content.active').hide().removeClass('active');
      $contents.find('.tab-content').filter('#' + targetTabId).show().addClass('active');

      $tab.trigger('tab_active');

    });
  });

});