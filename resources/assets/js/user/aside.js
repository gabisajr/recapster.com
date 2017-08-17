define(['jquery', 'modal/media-viewer', 'subscribe'], function ($, mediaViewer) {

  var aside = $('.user-aside')
    , editStatus = aside.find('.edit-status');

  if (editStatus.length) {
    requirejs(['editable'], function () {
      editStatus.editable();
    });
  }

  $('.profile-aside.user-aside img.avatar').click(function () {
    mediaViewer.open(this, {
      duration: 500,
      avatar: true
    });
  });

});