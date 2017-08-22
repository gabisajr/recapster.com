// console.log('common loaded');

requirejs.config({

  baseUrl: '/js',

  //useful modules
  paths: {
    moment: '/js/module/moment',
    jquery: '/lib/jquery-3.2.0.min',
    json: '/lib/require-modules/json',
    text: '/lib/require-modules/text.min',
    powerTip: '/lib/jquery.powertip-1.2.0/jquery.powertip.min',
    fancybox: '/lib/fancybox-3.0/jquery.fancybox.min',
    i18n: '/js/module/i18n',
    autosize: '/lib/autosize.min',
    async: '/lib/async.min',
    modal: '/js/modal',
    fancytree: '/lib/fancytree/jquery.fancytree-all.min',
    'fancytree-glyph': '/lib/fancytree/src/jquery.fancytree.glyph',
    'jquery-ui': '/lib/jquery-ui-1.11.4/jquery-ui.min',
    'jquery.ui.widget': '/lib/jquery.ui.widget.min',
    'perfect-scrollbar': '/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min',
    tagEditor: '/lib/jquery-tag-editor/jquery.tag-editor.min',
    'jquery-caret': '/lib/jquery-tag-editor/jquery.caret.min',
    tinyMCE: '/lib/tinymce/js/tinymce/tinymce.min',
    inputmask: '/lib/jquery.inputmask.bundle.min',
    highlight: '/lib/jquery.highlight-5.closure',
    fileupload: '/lib/jquery-file-upload/js/jquery.fileupload',
    jcrop: '/lib/jcrop/jquery.Jcrop.min',
    module: ('/js/module'),
    bootstrap: '/lib/bootstrap-4.0.0-alpha.6/js/bootstrap.min',
    Tether: '/lib/tether.min',
    'bootstrap-switch': '/lib/bootstrap/bootstrap-switch.min',
    'bootstrap-star-rating': '/lib/bootstrap/bootstrap-star-rating/themes/krajee-svg/theme.min',
    Modernizr: '/lib/modernizr-custom',
    ckfinder: '/ckfinder/ckfinder',
    ckeditor: '/ckeditor/ckeditor',
    VK: '//vk.com/js/api/openapi.js?132',
    VK_share: 'http://vk.com/js/api/share.js?90',
    facebook_sdk: '//connect.facebook.net/ru_RU/sdk',
    lightwidget: '//lightwidget.com/widgets/lightwidget',
    'twitter-wjs': 'https://platform.twitter.com/widgets',
    enquire: '/lib/enquire.min',
    'jquery-touchSwipe': '/lib/jquery.touchSwipe.min',
    'jquery.transform2d': '/lib/jquery.transform2d',
    'jquery.easing': '/lib/jquery.easing.min',
    select2: '/lib/select2/js/select2.min'
  },

  //not AMD modules
  shim: {
    facebook_sdk: {
      exports: 'FB'
    },
    VK: {
      exports: 'VK'
    },
    VK_share: {
      exports: 'VK'
    },
    jquery: {
      exports: 'jQuery'
    },
    tinyMCE: {
      exports: 'tinyMCE'
    },
    ckfinder: {
      exports: 'CKFinder'
    },
    ckeditor: {
      exports: 'CKEDITOR'
    },
    fancybox: {
      deps: ['jquery']
    },
    'fancytree-glyph': {
      deps: ['jquery', 'fancytree']
    },
    fancytree: {
      deps: ['jquery-ui']
    },
    tagEditor: {
      deps: ['jquery-caret']
    },
    'jquery-caret': {
      deps: ['jquery']
    },
    inputmask: {
      deps: ['jquery']
    },
    highlight: {
      deps: ['jquery']
    },
    jcrop: {
      deps: ['jquery']
    },
    'bootstrap-switch': {
      deps: ['bootstrap']
    },
    'bootstrap-star-rating': {
      deps: ['bootstrap', '/lib/bootstrap/bootstrap-star-rating/js/star-rating.min.js']
    },
    bootstrap: {
      deps: ['jquery']
    },
    'jquery.transform2d': {
      deps: ['jquery']
    },
    'jquery.ui.widget': {
      deps: ['jquery']
    }
  }

});

define('app_name', 'Recapster');

define('keyCodes', {
  ESC: 27,
  ENTER: 13,
  RIGHT: 39,
  LEFT: 37
});

define('caretEnd', ['jquery'], function ($) {
  return function () {
    var input = $(this)
      , val = input.val();
    input.val('');
    input.val(val);
  }
});

define('getImgRealSize', function () {
  return function (imgSrc, callback) {
    var newImg = new Image();
    newImg.onload = function () {
      callback({
        height: newImg.height,
        width: newImg.width
      });
    };
    newImg.src = imgSrc;
  }
});