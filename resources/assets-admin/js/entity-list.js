define(['jquery', 'notify'], function ($) {

  $.fn.entityList = function (params) {
    params = params || {};

    var removeUrl = params.removeUrl;
    if (!removeUrl) return window.alert('specify removeUrl');

    var sortUrl = params.sortUrl;
    if (params.sortable && !sortUrl) return window.alert('specify sortUrl');

    var $table = $(this);

    //remove entity
    params.afterRemove = params.afterRemove || false;
    $table.find('button[name=remove]').click(function (e) {
      e.preventDefault();

      var $btn = $(this);
      var $tr = $btn.closest('tr');
      var id = $tr.data('id');

      var title = $tr.find('.title').text().trim();
      if (title.length > 45) title = title.substring(0, 45) + '…';

      var removeQuestion = 'Confirm delete <strong>' + title + '</strong>';
      if (params.removeQuestion) {
        removeQuestion = params.removeQuestion.replace('{title}', title);
      }

      window.confirmModal(removeQuestion, function () {
        $.ajax({
          url: removeUrl,
          type: 'post',
          data: {id: id},
          beforeSend: function () {
            $btn.prop('disabled', true);
          },
          success: function () {
            window.alertMessage('Успешное удаление', 'success');
            $tr.fadeOut(function () {
              $tr.remove();
              params.afterRemove && params.afterRemove();
            });
          },
          error: function (jqXHR) {
            $.notify(jqXHR.responseText, 'error');
          }
        });
      });

    });

    //sort
    $table.find('button[name="sort"]').click(function (e) {
      e.preventDefault();

      var $sort_btn = $(this);

      var sort_arr = [];
      $table.find('tbody tr').each(function () {
        var $tr = $(this);
        sort_arr.push({
          id: $tr.data('id'),
          sort: $tr.find('input[name=sort]').val() || 0
        });
      });

      $.ajax({
        url: sortUrl,
        data: {sort_arr: sort_arr},
        type: 'post',
        beforeSend: function () {
          $sort_btn.find('.fa').show();
        },
        complete: function () {
          $sort_btn.find('.fa').hide();
        },
        error: function (jqXHR) {
          var message = jqXHR.status === 404 ? 'Error 404: URL not found' : jqXHR.responseText;
          window.alertMessage(message, 'error');
        },
        success: function () {
          location.reload();
        }
      })

    });
  };

});