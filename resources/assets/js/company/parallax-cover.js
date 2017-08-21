define(['jquery'], function ($) {

  var cover = $('.company-page-cover.with-cover-img')
    , img = cover.find('img.cover-img');

  if (!cover.length) return;

  function updateParallax() {
    var coverTop = cover.offset().top
      , pageScroll = $(document).scrollTop()
      , translateY = pageScroll > coverTop ? (pageScroll - coverTop) / 2 : 0;
    img.css('transform', 'translate(0px, ' + translateY + 'px)');
  }

  cover.on('updateParallax', updateParallax);

  $(window).resize(updateParallax);
  $(document).scroll(updateParallax).trigger('scroll');

});