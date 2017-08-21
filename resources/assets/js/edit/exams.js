define(['jquery', 'powertip'], function ($, powertip) {

  var form = $('form#exams-form')
    , examsList = form.find('.exams-list')
    , submit = form.find('.btn-submit');

  //добавить еще экзамен
  form.find('.add-exam').click(function (e) {
    e.preventDefault();
    var newIndex = form.find('.exam-form-group').length;
    $.post('/tmpl/edit/exams/form-group', {index: newIndex}, function (tmpl) {
      var group = $(tmpl);
      powertip(group.find('.powertip'));
      group.appendTo(examsList);
      group.find('input.title').focus();
    });
  });

  form.on('change', ':input', function () {
    $(this).closest('.has-error').removeClass('has-error');
  });

  //удалить экзамен
  form.on('click', '.group-delete', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).closest('.group').remove();
    $.post('/exam/delete', $(this).data());
  });


  //<editor-fold desc="submit">
  form.submit(function (e) {
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
            var group = $('.exam-form-group').eq(index);
            $.each(errors, function (name, err) {
              var input = group.find(':input.' + name);
              input.closest('.form-group, .col').addClass('has-error');
            });
          });


          //scroll to group with error
          var group = $('.exam-form-group .has-error').eq(0).closest('.exam-form-group');
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

});