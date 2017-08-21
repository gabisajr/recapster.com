define(['jquery', 'async'], function ($, async) {

  var form = $('form#delivery-form')
    , log = $('.delivery-log')
    , progress = $('#delivery-progress')
    , submit = form.find(':input[type=submit]');

  form.submit(function (e) {
    e.preventDefault();

    var template = form.find(':input[name=template]').val();
    var subject = form.find(':input[name=subject]').val();
    var rows = form.find(':input[name=email]').val().split('\n');
    var total = rows.length;
    log.text('');
    submit.prop('disabled', true);

    if (template) {
      async.eachOfSeries(rows, function (row, index, callback) {

        var email = row.split('|')[0];
        var name = row.split('|')[1];

        var data = {
          template: template,
          email: email,
          name: name,
          subject: subject
        };

        $.ajax({
          url: '/admin/delivery/send',
          type: 'post',
          data: data,
          success: function (res) {
            logRecord(email, name, res.success);
          },
          error: function () {
            logRecord(email, name, false);
          },
          complete: function () {
            doProgress(index, total);
            callback(null);
          }
        });

      });
    }

  });

  function doProgress(index, total) {
    var curr = index + 1;
    var percent = Math.round(curr / total * 100);
    var text = '' + curr + '/' + total + ' (' + percent + '%)';
    progress.css('width', percent + '%').attr('aria-valuenow', percent).text(text);
    if (percent >= 100) {
      progress.removeClass('progress-bar-striped active');
      submit.prop('disabled', false);
    } else {
      progress.addClass('progress-bar-striped active');
    }
  }

  function logRecord(email, name, success) {
    var li = $('<li><small>' + email + ', ' + name + '</small></li>');
    if (success) {
      li.addClass('text-success');
    } else {
      li.addClass('text-danger');
    }
    log.append(li);
  }

});