define(['jquery', 'modal/media-viewer', './aside.js', './parallax-cover.js', 'search', 'fast-image-upload'], function ($, mediaViewer) {

  //фотогаллерея
  (function (images) {

    if (!images.length) return;

    var jsonId = images.data('target')
      , data = JSON.parse($('script#' + jsonId).html())
      , btnMore = $('.btn-load-more');

    function beforeLoad() {
      //если долистали до конца, тогда подгружаем еще
      var count = images.find('.search-post').length;
      if (this.index > (count - 1)) btnMore.click();
    }

    images.on('click', '.bubble-image', function (e) {
      e.preventDefault();

      mediaViewer.open(this, data, {
        index: $(this).data('index'),
        container: images
        //todo load more on end
      });

      // require(['modal/image'], function (openModal) {
      //   openModal(data, {index: index, beforeLoad: beforeLoad});
      // });
    });

  })($('.search-results'));

  require(['swipe-tabs']);

});