requirejs.config({

  baseUrl: '/assets-admin/js',

  //useful modules
  paths: {
    ckfinder: '/ckfinder/ckfinder',
    ckeditor: '/ckeditor/ckeditor',
    jquery: '/lib/jquery-3.2.0.min',
    i18n: '/js/module/i18n',
    autocomplete: '/js/autocomplete',
    String: '/js/String',
    bootstrap: '/lib/bootstrap-4.0.0-alpha.6/js/bootstrap.min',
    'jquery-ui': '/lib/jquery-ui-1.11.4/jquery-ui.min',
    highlight: '/lib/jquery.highlight-5.closure',
    select2: '/lib/select2/js/select2.min',
    tagEditor: '/lib/jquery-tag-editor/jquery.tag-editor.min',
    'jquery-caret': '/lib/jquery-tag-editor/jquery.caret.min',
    notify: '/lib/notify.min',
    autosize: '/lib/autosize.min'
  },
  shim: {
    'jquery-ui': {
      deps: ['jquery']
    },
    highlight: {
      deps: ['jquery']
    },
    ckeditor: {
      exports: 'CKEDITOR'
    },
    ckfinder: {
      exports: 'CKFinder'
    },
    tagEditor: {
      deps: ['jquery-caret']
    },
    'jquery-caret': {
      deps: ['jquery']
    },
    notify: {
      deps: ['jquery']
    }
  }

});

define('caretEnd', ['jquery'], function ($) {
  return function () {
    var input = $(this)
      , val = input.val();
    input.val('');
    input.val(val);
  }
});