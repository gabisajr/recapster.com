define(['jquery', 'search'], function ($) {

  //fave jobs in sidebar
  $(document).on('click', '.fave-job .btn-fave', function (e) {
    e.preventDefault();
    var job = $(this).prop('disable', true).closest('.fave-job')
      , id = job.data('id')
      , panel = job.closest('.panel')
      , total = panel.find('.total');

    job.fadeOut(function () { job.remove() });

    $.post('/job/fave/' + id, function (res) {
      total.text('(' + res.total + ')');
      if (!res.total) panel.fadeOut(function () { panel.remove() });
    });
  });

});