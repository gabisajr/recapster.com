define(['jquery', 'autosize', 'keyCodes'], function ($, autosize, keyCodes) {

  $.fn.extend({
    editable: function () {

      autosize(this);

      return this

        .keypress(function (e) {
          if (e.keyCode == keyCodes.ENTER) {
            e.preventDefault();
            $(this).closest('form').submit();
          }
        })

        .each(function () {
          var el = $(this)
            , form = el.closest('form');

          form.submit(function (e) {
            e.preventDefault();
            $.ajax({
              url: form.attr('action'),
              method: form.attr('method'),
              data: form.serialize(),
              beforeSend: function () {
                el.blur();
              }
            });
          });
        })

        ;

    }
  });

});