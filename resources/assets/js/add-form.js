define(['jquery', 'keyCodes', 'autocomplete', 'highlight'], function ($, keyCodes) {

  return function (addForm, callback) {

    var title = addForm.find('input.title')
      , site = addForm.find('input.site')
      ;

    title.focus(function () {
      addForm.addClass('focus');
    });
    if (title.is(':focus')) title.trigger('focus');

    addForm.find('input').keypress(function (e) {
      $(this).closest('.field').removeClass('has-error');
      if (e.keyCode == keyCodes.ENTER) {
        addForm.data('type', 'review');
        addForm.submit();
      }
    }).keydown(function (e) {
      if (e.keyCode == keyCodes.ESC) addForm.trigger('reset');
    });

    title.autocompleteCompany();

    addForm.find('.btn-submit').click(function (e) {
      e.preventDefault();
      addForm.data('type', this.value);
      addForm.submit();
    });

    addForm.submit(function (e) {
      e.preventDefault();

      if (!title.val().trim()) return title.focus();

      var type = addForm.data('type') || 'review'
        , data = addForm.serializeArray();

      data.push({name: 'type', value: type});

      $.post('/add/form', data, function (res) {
        if (res.form) {

          var form = $(res.form);
          addForm.trigger('hide').after(form);

          switch (type) {
            case 'image':
              var module = 'add-images';
              break;
            case 'review':
              module = 'review-form';
              break;
          }

          if (module) {
            require([module], function (initForm) {
              initForm(form, {autofocus: true}, function (item) {
                form.remove();
                addForm.show().trigger('reset');
                return callback(item);
              });
            });
          } else {
            window.alert('module not found');
          }

        } else {

          $.each(res.errors, function (name, err) {
            var input = addForm.find('input.' + name)
              , field = input.closest('.field');

            if (field.is(':visible')) {
              field.addClass('has-error');
              field.find('.help-block').text(err);
            } else {
              field.show();
            }
            input.focus();
          });

        }
      });
    });

    addForm.on('hide', function () {
      var form = $(this);
      form.hide();
      form.find('.has-error').removeClass('has-error');
      site.val('').closest('.field').hide();
    });

    addForm.on('show', function () {
      $(this).show();
      title.focus();
    });

    addForm.on('reset', function () {
      addForm.find('.has-error').removeClass('has-error');
      title.blur().val('');
      site.blur().val('');
      addForm.removeClass('focus');
    });

    $(document).on('click', '.add-form-cancel', function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).closest('form').remove();
      addForm.trigger('show');
    });

    $(document).click(function (e) {
      var isGo = $(e.target).hasClass('add-form-go');
      if (!site.val() && !title.val() && !isGo) addForm.trigger('reset');
    });

    addForm.click(function (e) {
      e.stopPropagation();
    });


    $(document).on('click', '.add-form-go', function (e) {
      e.preventDefault();
      title.focus();
    });

  };

});