import $ from 'jquery';
import 'fancybox';

export function open (e) {

  e && e.preventDefault && e.preventDefault();
  e && e.stopPropagation && e.stopPropagation();

  console.log(1);

  if ($(window).width() > 770) {

    $.fancybox.open({
      type: 'ajax',
      src: '/tmpl/modal/signup',
      padding: 0
    });
  } else {
    window.location.href = '/signup';
  }

}

$('.open-signup-modal').click(open);