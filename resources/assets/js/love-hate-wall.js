require(['/js/common.js', 'helper/util'], function () {

  require(['jquery', 'getAbsoluteUrl', 'module/tabs'], function ($, getAbsoluteUrl) {

    //<editor-fold desc="синхронное переключение вкладок на стене любви и ненависти">
    $('.love-hate-wall .tab').on('tab_active', function () {
      var data = $(this).hasClass('vk') ? 'vk' : 'facebook';
      $('.tab.' + data).not(this).not('.active').click();
      $.post('/prefersocial', {social: data});

      //dynamic page url
      history.replaceState(null, document.title, getAbsoluteUrl('/love-hate-wall?tab=' + data));
    });
    //</editor-fold>

  });

});