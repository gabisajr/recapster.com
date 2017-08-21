require(['/js/common.js'], function () {

  require(['jquery', 'modal/job-application'], function ($, openModal) {

    var $tbl = $('table#tbl-candidates');

    $tbl.find('.open').click(function (e) {
      e.preventDefault();
      var data = $(this).closest('.application-data').data();
      openModal(data, $tbl);
    });

    $(document).ready(function () {
      var autoOpenId = $tbl.data('auto-open');
      if (autoOpenId) {
        $tbl.find('.application-data[data-id="' + autoOpenId + '"]').find('.open').click();
      }
    });

  });

});