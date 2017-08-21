define(['jquery', 'caretEnd', 'autosize', 'i18n', 'fancybox', 'mark-widget', 'autocomplete'], function ($, caretEnd, autosize, __) {

  return function (form, params, callback) {
    if (!form.length) return;
    params = params || {};

    var markWidget = form.find('.mark-widget').markWidget()
      , text = form.find(':input#text')
      , position = form.find(':input#position')
      , city = form.find(':input#city')
      , btnSubmit = form.find('.btn-submit');

    autosize(text);
    text.focus(caretEnd);
    position.focus(caretEnd);

    if (params.autofocus) text.focus();

    //расширенный отзыв
    form.find('.show-additional').click(function () {
      var show = $(this)
        , caret = show.find('.caret')
        , additionalFields = form.find('.additional-fields').toggle();

      if (additionalFields.is(':visible')) {
        position.focus();
        caret.addClass('caret-up');
      } else {
        caret.removeClass('caret-up');
      }

      $.fancybox.update();
    });

    //автодополнение должности
    position.autocompletePosition().autocomplete("widget").addClass("sm");
    city.autocompleteCity().autocomplete("widget").addClass("sm");

    form.submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),
        beforeSend: function () {
          btnSubmit.prop('disabled', true);
        },
        complete: function () {
          btnSubmit.prop('disabled', false);
        },
        success: function (res) {
          if (res.success) {
            $.fancybox.close();
            text.val('');
            return callback(res.review);
          }
          $.each(res.errors, function (name) {
            if (name == 'rating') {
              markWidget.addClass('mark-widget-error').find('.mark-widget-caption').addClass('shake');
            } else {
              form.find(':input[name="' + name + '"]').focus();
            }
          });
        }
      })
    });

    //запрет закрытия окна если есть текст
    window.onbeforeunload = function (e) {
      if (text.is(':visible') && text.val().trim()) {
        e = e || window.event;
        var dialogText = __('Вы уверены?');
        if (e) e.returnValue = dialogText;
        return dialogText;
      }
    };

  };

});