define(['jquery', 'i18n'], function ($, __) {

  //toggle edit form
  $('form.toggle-edit-form').each(function () {

    var form = $(this)
      , toggle = form.find('.toggle-edit')
      , input = form.find(':input[type="text"]')
      , name = input.attr('name')
      , formGroup = input.closest('.form-group')
      , inputGroup = input.closest('.input-group')
      , error = $('<p class="help-block small"></p>').insertAfter(inputGroup).hide();

    toggle.click(function (e) {
      e.preventDefault();

      form.toggleClass('open');
      if (form.hasClass('open')) {
        toggle.text(__('Отмена'));
        input.focus();
      } else {
        toggle.text(toggle.data('has') ? __('Изменить') : __('Добавить'));
      }
    });

    form.submit(function (e) {
      e.preventDefault();

      $.ajax({
        url: form.attr('action'),
        method: 'post',
        data: form.serialize(),
        beforeSend: function () {
          form.find('.btn-submit').prop('disabled', true);
        },
        complete: function () {
          form.find('.btn-submit').prop('disabled', false);
        },
        success: function (res) {
          if (res.success) {
            if (res.redirect) {
              window.location.href = res.redirect;
            } else {
              window.location.reload();
            }
          } else {
            formGroup.addClass('has-error');
            input.val(res.value);
            error.text(res.errors[name]).show();
          }
        }
      });
    })
  });


  //отлючить аккаунт ВКонтакте
  $('.remove-vk').click(function (e) {
    e.preventDefault();
    $(this).replaceWith('<img src="/images/loading.svg" class="loader">');
    $.post('/vkauth/remove', function () {
      window.location.reload();
    })
  });

  //отлючить аккаунт Facebook
  $('.remove-facebook').click(function (e) {
    e.preventDefault();
    $(this).replaceWith('<img src="/images/loading.svg" class="loader">');
    $.post('/fbauth/remove', function () {
      window.location.reload();
    })
  });

});