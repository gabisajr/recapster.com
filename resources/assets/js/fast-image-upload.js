define(['jquery', 'modal/signin'], function ($, signin) {

  $(document).on('click', '.fast-image-upload', function (e) {
    e.preventDefault();

    //проверка на авторизацию
    var logged = $('body').data('logged');
    if (!logged) return !signin();

    //проверка на url загрузки
    var url = $(this).data('url');
    if (!url) return;

    var form = $('<form method="post" action="' + url + '" enctype="multipart/form-data"><input type="file" name="images[]" multiple></form>')
      , file = form.find('input[type=file]').click();

    file.change(function () {
      if (this.files || this.files.length) {
        form.submit();
      }
    });
  });

});