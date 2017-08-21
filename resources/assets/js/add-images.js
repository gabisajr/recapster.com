define(['jquery', 'caretEnd', 'autosize', 'i18n', 'jquery-ui', 'Modernizr', 'fileupload'], function ($, caretEnd, autosize, __) {

  return function (form, params, callback) {
    if (!form.length) return;
    params = params || {};

    var btnSubmit = form.find('[type="submit"]')
      , text = form.find(':input[name="text"]')
      , container = form.find('.images-container')
      , fileupload = form.find('.fileupload')
      , addTile = form.find('.add-image')
      , tmpl = form.find('#tmpl-upload-item').html().trim()
      , maxNumberOfFiles = 10
      , restrictDelete = false;

    autosize(text);
    text.focus(caretEnd);
    if (params.autofocus) text.focus();

    container.sortable({
      start: function (event, ui) {
        ui.item.removeClass('zoom-in');
      }
    });

    fileupload.fileupload({
      url: '/upload/photo',
      paramName: 'photo',
      add: function (e, data) {
        if (!data.files || !data.files.length) return false;
        if (container.find('.upload-item').length == maxNumberOfFiles) {
          return false;
        }

        var file = data.files[0]
          , item = $(tmpl).uniqueId()
          , preview = item.find('img.preview');

        //show preview if FileReader support
        if (Modernizr.filereader) {
          (function (preview) {
            var fr = new FileReader();
            fr.onload = function () { preview.attr('src', fr.result) };
            fr.readAsDataURL(file);
          })(preview);
        } else {
          preview.hide();
        }

        item.addClass('zoom-in').appendTo(container);

        data.formData = {id: item.attr('id')};
        data.submit();
        btnSubmit.prop('disabled', true);

        if (container.find('.upload-item').length == maxNumberOfFiles) {
          addTile.hide();
        }

      },
      done: function (e, data) {
        var item = container.find('.upload-item#' + data.formData.id);

        item.data('path', data.result.path);
        item.find('.panel-loader').fadeOut(function () { $(this).remove() });
        item.find('.delete').show();

        if (!Modernizr.filereader) {
          item.find('img.preview').attr('src', data.result.path).fadeIn(150);
        }

      },
      stop: function () {
        btnSubmit.prop('disabled', false);
      }
    });


    form.on('click', '.upload-item .delete', function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (restrictDelete) return false;

      //visual delete
      var item = $(this).closest('.upload-item').addClass('zoom-out');
      setTimeout(function () {
        item.remove();
        addTile.show();
      }, 300);

      var path = item.data('path');
      if (path) $.post('/upload/remove', {path: path});

      //     var imageId = _this.data('imageId');
      //     if (imageId) $.post('/image/remove/' + imageId);

      var count = container.find('.upload-item-preview').length;
      if (!count) btnSubmit.prop('disabled', true);

    });

    form.submit(function (e) {
      e.preventDefault();

      var data = form.serializeArray();

      container.find('.upload-item').each(function () {
        $.each($(this).data(), function (name, value) {
          data.push({name: 'photo[' + name + '][]', value: value});
        });
      });

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: data,
        beforeSend: function () {
          form.find('input[type=file]').prop('disabled', true);
          btnSubmit.prop('disabled', true);
          restrictDelete = true;
        },
        complete: function () {
          form.find('input[type=file]').prop('disabled', false);
          btnSubmit.prop('disabled', false);
          restrictDelete = false;
        },
        success: function (res) {
          container.html('');
          return callback(res);
        }
      });
    });

    //запрет закрытия окна если есть не загруженные фотки
    window.onbeforeunload = function (e) {
      if (container.is(':visible') && container.find('.upload-item').length) {
        e = e || window.event;
        var dialogText = __('Вы уверены?');
        if (e) e.returnValue = dialogText;
        return dialogText;
      }
    };

  };

});