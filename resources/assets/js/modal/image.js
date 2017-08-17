define(['jquery', 'modal', 'fancybox', 'editable'], function ($, modal) {

  var imageParams = {
    type: 'ajax',
    padding: 0,
    tpl: {
      next: '<button class="fancybox-nav fancybox-next"><i class="icon arrow-right"></i></but>',
      prev: '<button class="fancybox-nav fancybox-prev"><i class="icon arrow-left"></i></button>',
      closeBtn: modal.close
    },
    scrolling: 'no',
    wrapCSS: 'image-modal-wrapper',
    helpers: {
      overlay: {locked: false}
    },
    preload: 10,
    loop: false,
    openEffect: 'none',
    closeEffect: 'none',
    nextEffect: 'none',
    prevEffect: 'none',
    afterLoad: function () {
      var content = $(this.content)
        , img = content.find('img.image-modal-img');

      img.load(function () {
        $.fancybox.reposition();
        init();
      });
    }
  };

  function init() {
    var modal = $('.image-modal')
      , edit = modal.find('.editable');

    edit.editable();

    modal.find('.delete').click(function (e) {
      e.preventDefault();
      $.post('/image/remove/' + $(this).data('id'), function () {
        $.fancybox.close();
        window.location.reload();
      });
    });

    modal.find('.claim').click(function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      if ($('body').data('logged')) {
        require(['modal/complain'], function (open) { open('image', id) });
      } else {
        require(['modal/signin'], function (signin) { signin() });
      }
    });
  }


  return function (data, params) {
    var openParams = $.extend({}, imageParams, params);
    $.fancybox.open(data, openParams);
  };

});