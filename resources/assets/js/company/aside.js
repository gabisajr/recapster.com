define(['jquery', 'modal/media-viewer', 'subscribe'], function ($, mediaViewer) {
  var $aside = $('.company-aside');

  $aside.find('.logo').click(function () {
    mediaViewer.open(this, {
      duration: 500
    });
  });

});