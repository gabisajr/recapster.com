define(['jquery', 'String'], function ($) {

  requirejs(['Tether'], function (Tether) {
    window.Tether = Tether;
    requirejs(['bootstrap']);
  });

  requirejs(['header']);

  //<editor-fold desc="tooltips">
  $(document).ready(function () {
    //todo use bootstrap 4 tooltips http://v4-alpha.getbootstrap.com/components/tooltips/
    // requirejs(['powertip'], function (powertip) {
    //   powertip($('.powertip'));
    // });
  });
  //</editor-fold>

  //<editor-fold desc="textarea maxlength && autosize">
  (function () {
    $('textarea[maxlength]')
      .wrap('<div class="maxlength-wrap"></div>')
      .before('<span class="minor gray maxlength-counter"></span>')
      .bind('updateCounter', updateCounter)
      .each(updateCounter)
      .keypress(updateCounter)
      .keyup(updateCounter);

    function updateCounter() {
      var $textarea = $(this)
        , $counter = $textarea.siblings('.maxlength-counter')
        , max = $textarea.attr('maxlength')
        , len = $textarea.val().length;

      $counter.text(len + ' из ' + max + ' символов');
    }

    requirejs(['autosize'], function (autosize) {
      autosize($('textarea.autosize'));
    });
  })();
  //</editor-fold>

  //<editor-fold desc="модалка с котиками регистрации">
  (function () {
    if ($('.open-signup-modal').length) requirejs(['modal/signup']);
    if ($('.open-signin-modal').length) requirejs(['modal/signin']);
  })();
  //</editor-fold>

  requirejs(['modal/alert']);

});