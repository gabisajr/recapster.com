define(['/vendor/moment.js'], function (moment) {
  var lang = document.getElementsByTagName('html')[0].getAttribute('lang');
  window.lang = lang;
  moment.locale(lang);
  return moment;
});