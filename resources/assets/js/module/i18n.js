define('i18n', ['jquery', 'String'], function ($) {

  return function (text, params) {

    var res = text; //todo i18n

    if (params) {
      $.each(params, function (name, value) {
        res = res.replaceAll(name, value);
      });
    }

    return res;
  };

});