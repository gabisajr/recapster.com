define(['jquery', 'i18n', 'caretEnd', 'autosize', 'powertip', 'autocomplete'], function ($, __, caretEnd, autosize, powertip) {

  var form = $('form#experience-form')
    , list = form.find('.experience-list');

  form.find('.experience-form-group').each(function () { expGroup($(this)) });

  //добавить еще опыт
  form.find('.add-experience').click(function (e) {
    e.preventDefault();
    var newIndex = form.find('.experience-form-group').length;
    $.post('/tmpl/edit/experience/form-group', {index: newIndex}, function (tmpl) {
      var group = expGroup($(tmpl));
      list.append(group);
      group.find('input.company_title').focus();
    });
  });

  //удалить опыт
  form.on('click', '.group-delete', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).closest('.group').remove();
    $.post('/experience/delete', $(this).data());
  });

  //<editor-fold desc="submit">
  form.submit(function (e) {
    var submit = form.find('[type="submit"]');
    e.preventDefault();

    $.ajax({
      url: form.attr('action'),
      data: form.serialize(),
      type: form.attr('method'),
      beforeSend: function () {
        submit.prop('disabled', true);
        form.find('.has-error').removeClass('has-error');
      },
      complete: function () {
        submit.prop('disabled', false);
      },
      success: function (res) {
        if (res.success) {
          window.scrollTo(0, 0);
          window.location.reload();
        } else {

          $.each(res.errors, function (index, errors) {
            var group = $('.experience-form-group').eq(index);
            $.each(errors, function (name, err) {
              var input = group.find(':input.' + name);
              input.closest('.form-group, .col').addClass('has-error');
            });
          });


          //scroll to group with error
          var group = $('.experience-form-group .has-error').eq(0).closest('.experience-form-group');
          if (group.length) {
            $('html, body').animate({
              scrollTop: group.offset().top
            }, 100);
          }
        }
      }
    });
  });
  //</editor-fold>
  
  function expGroup(group) {

    powertip(group.find('.powertip'));

    group.find('input.company_title').not('.ui-autocomplete-input').autocompleteCompany();
    group.find('input.position_title').not('.ui-autocomplete-input').autocompletePosition();
    group.find('input.city_title').not('.ui-autocomplete-input').autocompleteCity();

    var is_current = group.find('input.is_current')
      , end_month = group.find('select.end_month')
      , end_year = group.find('select.end_year')
      , text = group.find('textarea.text')
      , has_text = group.find('input.has_text')
      , textWrapper = group.find('.text-wrapper');

    text.focus(caretEnd);
    autosize(text);

    //отметил галочку "По настоящее время"
    is_current.change(function () {
      var checked = $(this).is(':checked');
      end_month.prop('disabled', checked).closest('.has-error').removeClass('has-error');
      end_year.prop('disabled', checked).closest('.has-error').removeClass('has-error');
    });

    //переклчить видимость текста
    has_text.change(function () {
      var checked = $(this).is(':checked');
      if (checked) {
        textWrapper.show();
        text.focus();
      } else {
        textWrapper.hide();
      }
    });

    return group;
  }

});