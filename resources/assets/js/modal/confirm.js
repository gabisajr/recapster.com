import $ from 'jquery';

// define(['tplModalClose', 'fancybox'], function (tplModalClose) {
//
// });

let $modal = $('#confirm-modal');
if (!$modal.length) {
  throw '#confirm-modal not found';
}

let $open = $('.open-confirm-modal').fancybox({
  padding: 0,
  fitToView: false,
  helpers: {
    overlay: {locked: false}
  },
  tpl: {closeBtn: tplModalClose}
});

let callback;

$modal.find('button[name="ok"]').click(function (e) {
  e.preventDefault();
  callback && callback(true);
});

$modal.find('button[name="no"]').click(function (e) {
  e.preventDefault();
  callback && callback(false);
});

export default function (message) {
  callback = arguments[1];
  $modal.find('.confirm-message').html(message);
  $open.click();
}