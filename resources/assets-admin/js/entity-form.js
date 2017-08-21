(function ($) {
  
  $.fn.entityForm = function (form_params) {

    if (!form_params.url) return;

    var $form = $(this);
    var img_upload_preview_template = $('#upload-preview-template').html();
    var file_upload_preview_template = $('#file-upload-preview-template').html();

    //<editor-fold desc="File upload">
    $form.find('input[type=file]').each(function () {
      var $file_input = $(this);
      var $form_group = $file_input.closest('.form-group');
      var upload_params = JSON.parse($form_group.find('script[data-upload-params]').html());
      var multiple = $file_input.attr('multiple') ? true : false;
      var required = $file_input.data('required') ? true : false;
      $file_input.data('multiple', multiple);

      //загрузка картинки
      if (upload_params.type == 'image') {

        $file_input.fileupload({
          url: '/image/upload',
          paramName: 'img',
          formData: {
            resize: upload_params.resize
          },
          beforeSend: function () {
            if (!multiple) {
              $form_group.find('figure.image-upload-preview').remove();
            }
            $form_group.append(img_upload_preview_template);
          },
          done: function (e, data) {
            var $preview = $form_group.find('figure.image-upload-preview.show-preloader').eq(0);
            $preview.removeClass('show-preloader');
            $preview.css('background-image', 'url(' + data.result.path + ')');
            $preview.find('.delete').show();
            $preview.data('path', data.result.path);

            if (required) $(this).removeAttr('required');
          }
        });
      } else

      //загрузка файла
      if (upload_params.type == 'file') {

        $file_input.fileupload({
          url: '/file/upload',
          paramName: 'file',
          beforeSend: function () {
            if (!multiple) {
              $form_group.find('.file-upload-preview').remove();
            }
            $form_group.append(file_upload_preview_template);
          },
          done: function (e, data) {
            $form_group
              .find('.file-upload-preview.show-preloader').eq(0)
              .removeClass('show-preloader')
              .addClass(data.result.type)
              .data('path', data.result.src)
              .data('file-type', data.result.type)
              .find('.title')
              .text(data.result.original_name);

            if (required) $(this).removeAttr('required');
          }
        });

      }
    });
    //</editor-fold>

    //<editor-fold desc="Remove images">
    $form.on('click', 'figure.image-upload-preview .delete', function () {

      var $form_group = $(this).closest('.form-group');
      var $file_input = $form_group.find('input[type=file]');
      var required = $file_input.data('required');
      var $figure = $(this).closest('figure');
      var path = $figure.data('path');

      $.ajax({
        url: '/admin/image/remove',
        type: 'post',
        data: { path: path },
        success: function () {
          $figure.fadeOut(450, function () {
            $figure.remove();

            //если все удалили то нужно вернуть аттрибут required
            if (required && $form_group.find('figure.image-upload-preview').length == 0) {
              $file_input.attr('required', 'required');
            }
          });
        }
      });
    });
    //</editor-fold>

    //<editor-fold desc="remove file">
    $form.on('click', '.file-upload-preview .delete', function () {

      var $form_group = $(this).closest('.form-group');
      var $file_input = $form_group.find('input[type=file]');
      var required = $file_input.data('required');
      var $preview = $(this).closest('.file-upload-preview');
      var path = $preview.data('path');

      $.ajax({
        url: '/file/delete',
        type: 'post',
        data: { path: path },
        success: function () {
          $preview.fadeOut(450, function () {
            $preview.remove();

            //если все удалили то нужно вернуть аттрибут required
            if (required && $form_group.find('figure.image-upload-preview').length == 0) {
              $file_input.attr('required', 'required');
            }
          });
        }
      });
    });
    //</editor-fold>

    //<editor-fold desc="Get files data">
    function getFilesData() {
      var result = {};
      $form.find('input[type=file]').each(function () {
        var $input = $(this);
        var multiple = $input.data('multiple');
        var input_name = $input.attr('name');
        var value;
        var $form_group = $input.closest('.form-group');
        var upload_params = JSON.parse($form_group.find('script[data-upload-params]').html());
        var uploadType = upload_params.type;

        if (uploadType == 'image') {
          if (multiple) {
            var arr = [];
            $form_group.find('figure.image-upload-preview').each(function () {
              arr.push({path: $(this).data('path')});
            });
            value = arr;
          } else {
            value = {
              path: $form_group.find('figure.image-upload-preview').eq(0).data('path')
            };
          }
        } else if (uploadType == 'file') {
          if (multiple) {
            arr = [];
            $form_group.find('.file-upload-preview').each(function () {
              var $preview = $(this);
              arr.push({
                path: $preview.data('path'),
                file_type: $preview.data('file-type'),
                original_name: $preview.find('.title').text()
              });
            });
            value = arr;
          } else {
            var $preview = $form_group.find('.file-upload-preview').eq(0);
            value = {
              path: $preview.data('path'),
              file_type: $preview.data('file-type'),
              original_name: $preview.find('.title').text()
            };
          }
        }

        result[input_name] = value;
      });
      result = decodeURIComponent($.param(result));
      return result;
    }

    //</editor-fold>

    //<editor-fold desc="ckeditor fields">
    CKFinder.setupCKEditor(null, '/ckfinder/');
    $form.find('textarea[data-ckeditor]').each(function () {
      var textarea_id = $(this).attr('id');
      CKEDITOR.replace(textarea_id, { extraPlugins: 'justify' });
    });

    //</editor-fold>

    //<editor-fold desc="form submit">
    $form.submit(function (e) {
      e.preventDefault();

      var $form = $(this);

      //update ckeditor values
      $form.find('textarea[data-ckeditor]').each(function () {
        var textarea_id = $(this).attr('id');
        CKEDITOR.instances[textarea_id].updateElement();
      });

      var data = $form.serialize() + '&' + getFilesData();

      $.ajax({
        url: form_params.url,
        type: 'post',
        data: data,
        beforeSend: function () {
          $form.find('button[type=submit] .fa').show();
        },
        complete: function () {
          $form.find('button[type=submit] .fa').hide();
        },
        success: function (res) {
          res.is_new = res.is_new || false;
          var callback = res.is_new ? form_params.afterAdd : form_params.afterUpdate;
          callback && callback();
        },
        error: function (jqXHR) {
          var message = jqXHR.status == 404 ? 'Error 404: URL not found' : jqXHR.responseText;
          alertMessage(message, 'error');
        }
      });
    });
    //</editor-fold>

  };

})(jQuery);