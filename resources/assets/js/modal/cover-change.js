/** Загрузка и обрезка обложки компании */
import $ from 'jquery';

// define(['tplModalClose', 'fileupload', 'fancybox', 'jcrop'], function (tplModalClose) {
//
// });

let modal = $('.modal#cover-change-modal')
  , preview = modal.find('#cover-change-preview')
  , sizetip = modal.find('.size-tip')
  , previewW = preview.parent()
  , buttons = modal.find('.buttons')
  , guideAspectRatio = $('.company-page-cover').data('aspect-ratio')
  , jcrop_api;

let minW = 970; //min profile layout width
let minH = minW / guideAspectRatio;

$('input#cover-change').fileupload({
  url: '/upload/photo',
  paramName: 'photo',
  change: clear,
  done: function (e, data) {

    let path = data.result.path;

    preview.attr('src', path).one("load", function () {

      previewW.removeClass('hidden');
      buttons.removeClass('hidden');
      $.fancybox.update();

      let $img = $(this);
      let W = $img.width();
      let H = $img.height();
      let imgAspectRatio = W / H;

      // смотрим разымеры не меньше положеного
      if ((W < minW) || (H < minH)) {
        sizetip.addClass('-fail shake');
        return clear();
      }

      sizetip.removeClass('-fail shake').hide();

      //select box size
      let w, h;
      if (imgAspectRatio < guideAspectRatio) {
        w = W;
        h = W / guideAspectRatio;
      } else if (imgAspectRatio > guideAspectRatio) {
        h = H;
        w = H * guideAspectRatio;
      }

      //select box coords
      let x = W / 2 - w / 2
        , y = H / 2 - h / 2
        , x1 = x + w
        , y1 = y + h;

      //select box diagonal
      let setSelect = [x, y, x1, y1];

      $img.Jcrop({
        aspectRatio: guideAspectRatio,
        minSize: [minW, minH],
        setSelect: setSelect,
        boxWidth: 750,
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

$('.open-cover-change-modal').fancybox({
  padding: 0,
  href: '#cover-change-modal',
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

let _x = modal.find('input[name=x]')
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
  let path = _path.val();
  if (path) $.post('/upload/remove', {path: path});


  $.each([_x, _y, _x2, _y2, _w, _h, _path], function (index, input) {
    input.val('');
  });
}