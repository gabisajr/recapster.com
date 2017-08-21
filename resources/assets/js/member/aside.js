define(['jquery'], function ($) {

  //<editor-fold desc="Фиксация бокового меню в личном кабинете при прокрутке страницы">
  $(document).ready(function () {

    var $nav = $('.side-nav')
      , navHeight = $nav.outerHeight()
      , $aside = $('#aside')
      , asideHeight = $aside.outerHeight()
      , $pageContent = $('.page-content')
      , pageContentHeight = $pageContent.outerHeight()

    //scroll bounds (px) for fixing aside nav
      , topLimit = $pageContent.offset().top - 14 // 14 - margin-top
      , botLimit = pageContentHeight + $pageContent.offset().top - navHeight - 42 - 14 //margin-bottom
      ;

    if (
      (navHeight == asideHeight) ||
      (navHeight >= asideHeight - 42 - 14)) {
      return; //не делать плавающее меню
    }

    calcNavFixed();
    $(window).scroll(calcNavFixed);

    function calcNavFixed() {
      var winScrollTop = $(window).scrollTop();

      if (winScrollTop > topLimit) {
        if (winScrollTop < botLimit) {
          $nav.removeClass('bottom').addClass('fixed');
        } else {
          $nav.removeClass('fixed').addClass('bottom');
        }
      } else {
        $nav.removeClass('fixed');
      }
    }

  });
  //</editor-fold>

});