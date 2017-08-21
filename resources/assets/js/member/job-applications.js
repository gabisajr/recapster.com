require(['/js/common.js'], function () {

  require(['jquery', 'i18n', 'showMessageModal'], function ($, __, showMessageModal) {

    var tbl = $('table#job-applications');

    //<editor-fold desc="архивация и удаление отклика">
    function setCount($el, count) {
      count ? $el.text(count) : $el.html('<span class="no">--</span>');
    }

    tbl.on('click', '.btn-archive', function (e) {
      e.preventDefault();

      var $btn = $(this);
      $btn.closest('tr').remove();

      $.post('/jobApplication/archive/' + $btn.data('id'), function (res) {

        var $tabs = $('#job-applications-tabs');
        setCount($tabs.find('.count.current'), res['current_count']);
        setCount($tabs.find('.count.archive'), res['archive_count']);

      });
    });

    tbl.on('click', '.btn-delete', function (e) {
      e.preventDefault();

      var $btn = $(this);

      $btn.closest('tr').remove();

      $.post('/jobApplication/delete/' + $btn.data('id'), function () {
        console.log('done')
      });
    });
    //</editor-fold>

    //<editor-fold desc="Просмотра текста ответа работодателя">
    var $job_responses_count = $('#account-menu').find('.job_responses_count');
    tbl.find('.apply-status.-invite, .apply-status.-fail').click(function () {

      var $this = $(this)
        , $row = $this.closest('tr.application-data');

      var title = __('Ответ работодателя');
      if ($this.hasClass('-invite')) {
        title = __('Вы приглашены на собеседование');
      } else if ($this.hasClass('-fail')) {
        title = __('Ваша кандидатура отклонена');
      }

      var message = $this.data('response');

      showMessageModal(message, title);

      var id = $row.data('id');
      $.post('/jobApplication/readResponse/' + id, function (count) {
        $job_responses_count.text(count ? '(+' + count + ')' : '');
        $row.removeClass('unread').find('.icon.envelope').remove();
      });

    });
    //</editor-fold>

  });

});