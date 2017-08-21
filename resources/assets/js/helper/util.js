/**
 * создаем DOM ссылку, и используем эту ссылку для конвертации относительных путей в полные
 */
define('getAbsoluteUrl', function () {

  var a; //singletone

  return function (url) {
    if (!a) a = document.createElement('a');
    a.href = url;
    return a.href;
  };

});