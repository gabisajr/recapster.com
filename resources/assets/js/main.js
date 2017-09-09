import $ from 'jquery';
import 'bootstrap';

import './header';

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': window.app.csrfToken
  }
});

//bootstrap tooltips
//todo replace all .powertip to attr data-toggle="tooltip"
$('[data-toggle="tooltip"]').tooltip();


{ //textarea autosize

  let $ta = $('textarea.autosize');
  if ($ta.length) require.ensure(['autosize'], function (require) {
    let autosize = require('autosize');
    autosize($ta);
  });
}


{ //textarea maxlength
  $('textarea[maxlength]')
    .wrap('<div class="maxlength-wrap"></div>')
    .before('<span class="minor gray maxlength-counter"></span>')
    .bind('updateCounter', updateCounter)
    .each(updateCounter)
    .keypress(updateCounter)
    .keyup(updateCounter);

  function updateCounter() {
    let $textarea = $(this)
      , $counter = $textarea.siblings('.maxlength-counter')
      , max = $textarea.attr('maxlength')
      , len = $textarea.val().length;

    $counter.text(len + ' из ' + max + ' символов');
  }
}

{ //модалка с котиками регистрации

  if ($('.open-signup-modal').length) {
    require.ensure(['modal-signup'], function (require) {
      require('modal-signup');
    });
  }

  if ($('.open-signin-modal').length) {
    require.ensure(['modal-signin'], function (require) {
      require('modal-signin');
    });
  }
}

//requirejs(['modal/alert']);