define(['jquery', 'enquire'], function ($, enquire) {

  //переход по ссылки нажатием на весь пост для моб версии
  function mobileGo(post) {
    enquire.register("screen and (max-width:767px)", {
      match: function () {
        post.click(go);
      },
      unmatch: function () {
        post.off('click', go);
      }
    });

    function go(e) {

      var disable = $(e.toElement).closest('.no-mobile-go').length || $(e.toElement).hasClass('no-mobile-go');
      if (disable) return;

      var post = $(this)
        , inner = post.find('.post-inner')[0]
        , url = post.data('url');

      if (url) {
        if (inner) {
          inner.classList.remove('tap-highlight');
          void inner.offsetWidth;
          inner.classList.add('tap-highlight');
        }

        window.location.href = url;
      }
    }
  }

  return {
    mobileGo: mobileGo
  };

});