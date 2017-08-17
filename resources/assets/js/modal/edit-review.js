define(['jquery', 'modal', 'fancybox'], function ($, modal) {

  function open(reviewId) {

    $.fancybox.open({
      type: 'ajax',
      padding: 0,
      tpl: {closeBtn: modal.close},
      helpers: {
        overlay: {locked: false}
      },
      href: '/review/form/' + reviewId,
      minWidth: 500,
      openEffect: 'none',
      closeEffect: 'none',
      scrolling: 'visible',
      afterShow: function () {
        require(['review-form'], function (initForm) {
          var form = $('.review-form');
          initForm(form, {autofocus: true}, function () { window.location.reload() });
          setTimeout(function () { $.fancybox.update() }, 100);
        });
      }
    });
  }

  return open;

});