/** Загрузка и обрезка логотипа компании */
define(['jquery', 'tplModalClose', 'fileupload', 'fancybox', 'jcrop'], function ($, tplModalClose) {

  var modal = $('.modal#logo-change-modal')
    , preview = modal.find('#logo-change-preview')
    , sizetip = modal.find('.size-tip')
    , previewW = preview.parent()
    , buttons = modal.find('.buttons')
    , jcrop_api;

  var minSize = 200; //min profile logo size

  $('input#logo-change').fileupload({
    url: '/upload/photo',
    paramName: 'photo',
    change: clear,
    done: function (e, data) {

      var path = data.result.path;

      preview.attr('src', path).one("load", function () {

        previewW.removeClass('hidden');
        buttons.removeClass('hidden');
        $.fancybox.update();

        var $img = $(this);
        var W = $img.width();
        var H = $img.height();

        // смотрим разымеры не меньше положеного
        if ((W < minSize) || (H < minSize)) {
          sizetip.addClass('-fail shake');
          return clear();
        }

        sizetip.removeClass('-fail shake').hide();

        var size = W < H ? W : H;
        size -= size * 0.1; //add padding

        var x = W / 2 - size / 2;
        var y = H / 2 - size / 2;
        var x1 = x + size;
        var y1 = y + size;

        var setSelect = [x, y, x1, y1];

        $img.Jcrop({
          aspectRatio: 1, //square
          minSize: [minSize, minSize],
          setSelect: setSelect,
          boxWidth: 500,
          boxHeight: 500,
          bgColor: '#ccc',
          onSelect: setCoords
        }, function () {
          jcrop_api = this
        });

      });

      _path.val(path);

    }
  });

  $('.open-logo-change-modal').fancybox({
    padding: 0,
    href: '#logo-change-modal',
    fitToView: false,
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: tplModalClose},
    beforeShow: function () {
      sizetip.show();
    },
    afterClose: clear
  });

  var _x = modal.find('input[name=x]')
    , _y = modal.find('input[name=y]')
    , _x2 = modal.find('input[name=x2]')
    , _y2 = modal.find('input[name=y2]')
    , _w = modal.find('input[name=w]')
    , _h = modal.find('input[name=h]')
    , _path = modal.find('input[name=path]');

  function setCoords(c) {
    _x.val(c.x);
    _y.val(c.y);
    _x2.val(c.x2);
    _y2.val(c.y2);
    _w.val(c.w);
    _h.val(c.h);
  }

  function clear() {

    buttons.addClass('hidden');
    previewW.addClass('hidden');

    if (jcrop_api) jcrop_api.destroy();
    preview.removeAttr('src style');

    //remove temp upload file
    var path = _path.val();
    if (path) $.post('/upload/remove', {path: path});


    $.each([_x, _y, _x2, _y2, _w, _h, _path], function (index, input) {
      input.val('');
    });
  }

});