import $ from 'jquery';

// define(['tplModalClose', 'fancybox'], function (tplModalClose) {
//
// });

$('.open-remove-account-modal').fancybox({
  padding: 0,
  fitToView: false,
  href: '#remove-account-modal',
  helpers: {
    overlay: {locked: false}
  },
  tpl: {closeBtn: tplModalClose}
});