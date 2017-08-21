/** модалка твитнуть */
define(['jquery'], function ($) {

  $(document).on('click', '.twitter-popup', function (e) {
    e.preventDefault();
    var width = 575
      , height = 253
      , left = ($(window).width() - width) / 2
      , top = ($(window).height() - height) / 2
      , url = this.href
      , opts = 'status=1' +
      ',width=' + width +
      ',height=' + height +
      ',top=' + top +
      ',left=' + left;

    window.open(url, 'twitter', opts);
  });

});