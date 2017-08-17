define(['jquery', 'fileupload'], function ($) {

  var form = $('form#start-form')
    , submit = form.find('.btn-submit');

  //загрузка аватарки
  (function () {
    var avatarBlock = form.find('.avatar-block')
      , tip = avatarBlock.find('.tip')
      , upload = avatarBlock.find('.avatar-block-upload')
      , avatar = upload.find('img.avatar')
      , loader = $('<div class="panel-loader"><img src="/images/loading.svg" class="loader"></div>').appendTo(upload).hide()
      , path = form.find('input[name="avatar"]');

    form.find('input#avatar').fileupload({
      url: '/upload/photo',
      beforeSend: function () {
        loader.fadeIn();
        submit.prop('disabled', true);
        $.post('/upload/remove', {path: path.val()});
      },
      complete: function () {
        loader.fadeOut();
        submit.prop('disabled', false);
      },
      done: function (e, data) {
        if (data.result.success) {
          path.val(data.result.path);
          avatar.attr('src', data.result.path);
          tip.css({opacity: 0, transition: 'opacity 0.5s'}).slideUp();
        }
      }
    });

  })();


});