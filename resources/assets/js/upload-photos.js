require(['/js/common.js'], function () {

  require(['jquery', 'async', 'fileupload', 'jquery-ui'], function ($, async) {

    var rowTmpl;

    $('.upload-photos')

      .on('add-row', function () {
        var $tbody = $(this).find('table.upload-photos-table tbody');

        async.waterfall([

          //get row template
          function (callback) {
            if (rowTmpl) return callback();
            $.get('/tmpl/partials/upload-photos-row', function (tmpl) {
              rowTmpl = tmpl;
              callback();
            });
          }

        ], function () {
          var row = $(rowTmpl), index = $tbody.find('.upload-photos-row:last-child').data('index') + 1;
          row.data('index', index).find('.photo-index-caption').text('Фото ' + index);
          initRow(row);
          $tbody.append(row);
        });
      })

      .on('click', '.btn-add-row', function (e) {
        e.preventDefault && e.preventDefault();
        $(this).closest('.upload-photos').trigger('add-row');
      })

      .on('click', '.btn-remove', function (e) {
        $(this).closest('.upload-photos-row').remove();

        //disabled submit button if not images
        var count = 0;
        $(e.delegateTarget).find('input.path').each(function () {
          if ($(this).val()) count++
        });
        if (!count) $(e.delegateTarget).closest('form').find('.btn-submit').prop('disabled', true);
      });

    $('.upload-photos .upload-photos-row').each(function () {
      initRow($(this))
    });

    function initRow(row) {
      var preview = row.find('.preview')
        , img = row.find('img.preview-image')
        , path = row.find('input.path')
        , originalName = row.find('.original-name');

      row.find('input[type="file"][name="photo"]').fileupload({
        url: '/upload/photo',
        add: function (e, data) {
          row.find('.btn-remove').click(function () {
            data.abort()
          });
          data.submit();
        },
        change: function (e, data) {
          var row = $(this).closest('.upload-photos-row');
          row.find('.btn-file, .three-dots').hide();
          row.find('.preview, .fields, .btn-remove').show();
          row.find('input.title').prop('required', true);

          if (data.files && data.files.length) {
            originalName.text(data.files[0].name);

            //show preview if FileReader support
            if (FileReader) {
              var fr = new FileReader();
              fr.onload = function () {
                img.attr('src', fr.result)
              };
              fr.readAsDataURL(data.files[0]);
            }
          }
        },
        done: function (e, data) {
          preview.find('.preloader').remove();
          path.val(data.result.path);
          $(e.target.form).find('.btn-submit:disabled').prop('disabled', false);
        }
      });

      //autocomplete location //todo remove
      row.find('input.location')
        .focusout(function () {

          var input = $(this)
            , fields = input.closest('.upload-photos-row').find('.fields')
            , targetInputName = input.data('target') || 'city'
            , targetInput = fields.find('input[name="' + targetInputName + '"]')
            , forTitle = targetInput.data('for-title');

          input.val(input.val().trim());

          //id не сооветствует надписи
          if (forTitle != input.val()) targetInput.val('').data('for-title', null);

        })
        .autocomplete({
          source: function (request, response) {
            $.ajax({
              type: 'POST',
              dataType: 'json',
              url: '/autocomplete/city',
              data: {filter: request.term},
              success: function (data) {
                response($.map(data, function (city) {
                  return {
                    label: city.title,
                    id: city.id
                  }
                }));
              }
            });
          },
          select: function (event, ui) {

            var input = $(this)
              , fields = input.closest('.upload-photos-row').find('.fields')
              , targetInputName = input.data('target') || 'city'
              , targetInput = fields.find('input[name="' + targetInputName + '"]');

            if (!targetInput.length) targetInput = $('<input type="hidden" name="' + targetInputName + '">').appendTo(fields);

            // по выбору - подставить id города
            targetInput.val(ui.item.id);

            setTimeout(function () {
              targetInput.data('for-title', input.val());
            }, 0);

          },
          minLength: 1
        })

        //кастомный шаблон
        .autocomplete("instance")._renderItem = function (ul, location) {

        var html = '<i class="icon map-marker"></i>' +
          '<div class="data">' +
          '<div class="location-title">' + location.label + '</div>' +
          '</div>';

        return $('<li class="ac-location-item">').append(html).appendTo(ul);
      };
    }

  });

});