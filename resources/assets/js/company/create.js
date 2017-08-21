define(['jquery', 'i18n'], function ($, __) {

  var form = $('form#add-company-form')
    , panel = form.closest('.panel')
    , loader = $('<div class="panel-loader"><img src="/images/loading.svg" class="loader"></div>').appendTo(panel).hide();

  form.submit(function (e) {
    e.preventDefault();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(),
      beforeSend: function () {
        form.find('.form-group').removeClass('has-error');
        loader.fadeIn();
      },
      complete: function () {
        loader.fadeOut();
      },
      success: function (res) {
        if (res.success) {
          panel.fadeOut(function () {
            panel.replaceWith('<div class="alert alert-success text-center">' + __('Компания успешно добавлена') + '</div>');
          });

        } else {
          res.errors = res.errors || [];
          $.each(res.errors, function (name, err) {
            var field = form.find('.form-group.' + name).addClass('has-error');
            var error = field.find('.text-danger');
            if (!error.length) error = $('<div class="text-danger small"></div>').prependTo(field);
            error.text(err).fadeIn(100);
          });
        }
      }
    })
  });

});