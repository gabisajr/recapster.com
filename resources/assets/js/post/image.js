define(['jquery'], function ($) {

  $.fn.extend({
    imagePost: function () {

      return this.each(function () {
        var activity = $(this)
          , activityId = activity.data('id')
          , images = activity.find('.images')
          , form, textarea;

        //модака с картинками
        (function () {
          var fancy = images.find('.fancy')
            , data = [];
          fancy.each(function () { data.push({href: '/image/modal/' + $(this).data('id')}) });
          if (data.length) require(['modal/image'], function (openImage) {
            fancy.click(function (e) {
              e.preventDefault();
              openImage(data, {index: $(this).data('index')});
            });
          });
        })();


        activity

        //редактирование
          .on('click', '.edit-activity', function (e) {
            e.preventDefault();

            if (form) return textarea.focus();

            var desc = activity.find('.post-desc');

            $.ajax({
              url: '/activity/editForm/' + activityId,
              success: function (form) {
                form = $(form);
                textarea = form.find('textarea');

                desc.hide();
                form.insertBefore(images);
                require(['caretEnd', 'autosize'], function (caretEnd, autosize) {
                  textarea.focus(caretEnd).focus();
                  autosize(textarea);
                });

                form.submit(function (e) {
                  e.preventDefault();
                  $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function (html) {
                      activity.replaceWith($(html).imagePost());
                    }
                  })
                }).find('.cancel').click(function (e) {
                  e.preventDefault();
                  form.remove();
                  desc.show();
                });

                require(['keyCodes'], function (keyCodes) {
                  textarea.keydown(function (e) {
                    if (e.keyCode == keyCodes.ESC) {
                      form.find('.cancel').click();
                    }
                  });
                });

              }
            });
          })

          //удаление
          .on('click', '.delete-activity', function (e) {
            e.preventDefault();
            activity.closest('.post-list-col').remove();
            activity.remove();
            $.post('/activity/delete/' + activityId);
          })

          //пожаловаться
          .on('click', '.complain-activity', function (e) {
            e.preventDefault();
            if ($('body').data('logged')) {
              require(['modal/complain'], function (open) { open('image_activity', activityId) });
            } else {
              require(['modal/signin'], function (signin) { signin() });
            }
          })

        ;
      });

    }
  });

});