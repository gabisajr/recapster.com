/** Ответить на отзыв или собеседование */
define(['jquery', 'autosize', 'i18n'], function ($, autosize, __) {

  $(document)

    .on('focus', 'form.add-review-comment-form textarea.comment', function () {
      var ta = $(this);
      ta.attr('rows', 2);
      autosize.update(ta);
      ta.closest('form').find('.buttons').removeClass('hidden');
    })

    .on('click', 'form.add-review-comment-form :input.btn-cancel', function () {
      var _form = $(this).closest('form');
      _form.find('.buttons').addClass('hidden');
      var ta = _form.find('textarea.comment').val('').attr('rows', 1);
      autosize.update(ta);
    })

    .on('submit', 'form.add-review-comment-form', function (e) {
      e.preventDefault();

      var _form = $(this), comment = _form.find('textarea.comment').val();
      if (!comment) return;

      _form.find(':input[type="submit"]').prop('disabled', true).find('.preloader').removeClass('hidden');

      $.post(_form.attr('action'), _form.serialize(), function (res) {
        if (res.success) {
          _form.replaceWith(res.comment);
        }
      });
    })

    .on('click', '.employer-comment .edit-comment', function (e) {
      e.preventDefault();

      var _comment = $(this).closest('.employer-comment')
        , data = $(this).data();

      $.post('/tmpl/form/add-employer-comment', data, function (html) {

        var $form = $(html);

        var ta = $form
          .attr('action', '/' + data.type + '/editComment/' + data.id)
          .find('textarea.comment')
          .val(_comment.find('.comment-text').text().trim());
        autosize(ta);

        $form.find(':input[type="submit"]>span').text(__('Сохранить'));

        _comment.replaceWith($form);
        ta.focus();

      });
    })

    .on('click', '.employer-comment .delete-comment', function (e) {
      e.preventDefault();

      var _comment = $(this).closest('.employer-comment')
        , data = $.extend({}, $(this).data(), {});

      $.post('/' + data.type + '/deleteComment/' + data.id, function (res) {
        if (res.success) {
          var $form = $(res.form);
          var ta = $form.find('textarea.comment');
          autosize(ta);
          _comment.replaceWith($form);
        }
      });
    });

});