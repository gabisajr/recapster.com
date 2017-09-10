import $ from 'jquery';
// require(['modal', 'fancybox'], function (modal) {
//
// });

$(document).ready(function () {
  $.fancybox.open({
    type: 'ajax',
    src: '/tmpl/modal/welcome',
    padding: 0,
    fitToView: true,
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: modal.close}
  });
});