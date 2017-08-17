define(['jquery'], function ($) {

  $('.open-signin-modal').click(signin);

  function signin(e) {
    e && e.preventDefault && e.preventDefault();

    var winWidth = $(window).width();
    if (winWidth < 767) {
      return window.location.href = '/signin';
    }

    console.log('openModal');
    require(['modal', 'fancybox'], function (modal) {
      $.fancybox.open({
        type: 'ajax',
        href: '/tmpl/modal/signin',
        padding: 0,
        fitToView: true,
        helpers: {
          overlay: {locked: false}
        },
        tpl: {closeBtn: modal.close}
      });
    });
  }

  return signin;

});