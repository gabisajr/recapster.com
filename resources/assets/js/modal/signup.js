require(['jquery', 'modal', 'fancybox'], function ($, modal) {

  function open(e) {

    e.preventDefault && e.preventDefault();
    e.stopPropagation && e.stopPropagation();

    if ($(window).width() > 770) {

      $.fancybox.open({
        type: 'ajax',
        padding: 0,
        fitToView: false,
        href: '/tmpl/modal/signup',
        helpers: {
          overlay: {locked: false}
        },
        tpl: {closeBtn: modal.close}
      });
    } else {
      window.location.href = '/signup';
    }

  }

  $('.open-signup-modal').click(open);

  return open;

});