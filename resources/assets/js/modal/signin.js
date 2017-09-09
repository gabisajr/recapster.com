import $ from 'jquery';
import 'fancybox';

export function open (e) {

  e && e.preventDefault && e.preventDefault();
  e && e.stopPropagation && e.stopPropagation();

  let winWidth = $(window).width();
  if (winWidth < 767) {
    return window.location.href = '/signin';
  }

  $.fancybox.open({
    type: 'ajax',
    src: '/tmpl/modal/signin',
    padding: 0
  });
}

$('.open-signin-modal').click(open);