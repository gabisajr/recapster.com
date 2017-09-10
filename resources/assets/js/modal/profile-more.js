import $ from 'jquery';

// define(['tplModalClose', 'fancybox'], function (tplModalClose) {
//
// });

$('.open-profile-more-modal').fancybox({
  padding: 0,
  fitToView: true,
  href: '#profile-more-modal',
  helpers: {
    overlay: {locked: false}
  },
  closeBtn: false
});