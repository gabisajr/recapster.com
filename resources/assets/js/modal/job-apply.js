define(['jquery', 'i18n', 'tplModalClose', 'fancybox', 'fileupload'], function ($, __, tplModalClose) {

  var $modal = $('#apply-job-modal')
    , $form = $modal.find('#apply-job-form')
    , $resume = $form.find('.resume');

  $('.open-apply-job-modal').fancybox({
    padding: 0,
    fitToView: false,
    href: '#apply-job-modal',
    scrolling: 'visible',
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: tplModalClose},
    beforeShow: function () {
      var data = $(this.element).data()
        , companyTitle = data['jobCompany']
        , jobTitle = data['jobTitle']
        , jobId = data['jobId'];

      $modal.find('.modal-title').html(jobTitle + ' для <em>' + companyTitle + '</em>');
      $form.find('input[name="job"]').val(jobId);
      $form.find('textarea[name="message"]').attr('placeholder', __('Расскажите :company почему они должны принять вас на работу', {
        ':company': companyTitle
      }));
    },
    afterShow: function () {
      $form.find(':input').filter(function () {

        var name = $(this).attr("name");
        var filtered = $.inArray(name, ['firstname', 'tel', 'email', 'city', 'message']);
        return filtered >= 0 && this.value == "";

      }).eq(0).focus();
    },
    afterClose: function () {
      $form.find(':input').removeClass('error');
      $form.find('.text-error').addClass('hidden').text('');
    }
  });

  //upload resume file
  $resume.find('input[name="file"]').fileupload({
    url: '/upload',
    change: function (e, data) {
      var filename = data.files[0].name.trim();
      $form.find('input[name="resume_name"]').val(filename);
      $resume.find('.filename').text(filename);
    },
    done: function (e, data) {
      $resume.find('input[name="resume"]').val(data.result.path);
      $resume.find('.btns').hide();
      $resume.find('.preview').show();
    }
  });

  //delete resume file
  $resume.find('.delete').click(function () {
    $resume.find('.btns').show();
    $resume.find('.preview').hide();
    var path = $resume.find('input[name="resume"]').val();
    $.post('/upload/remove', {path: path});
    $resume.find(':input').val('');
  });

  $form.submit(function (e) {
    e.preventDefault();

    var showPreloaderTm;

    $.ajax({
      url: $form.attr('action'),
      type: $form.attr('method'),
      data: $form.serialize(),
      beforeSend: function () {
        $form.find(':input').prop('disabled', true);
        showPreloaderTm = setTimeout(function () {
          $form.find('.preloader').show();
        }, 200);
      },
      complete: function () {
        $form.find(':input').prop('disabled', false);
        clearTimeout(showPreloaderTm);
        $form.find('.preloader').hide();
      },
      success: function (res) {

        $form.find('.text-error').text('').addClass('hidden');
        $form.find(':input').removeClass('error');

        if (res.success) {
          window.location.href = res.url;
        } else {
          var errors = res['errors'] || [];
          $.each(errors, function (field, message) {
            $form.find(':input[name="' + field + '"]').addClass('error');
            $form.find('.error-' + field).text(message).removeClass('hidden');
          });
        }
      }
    });

  });

});