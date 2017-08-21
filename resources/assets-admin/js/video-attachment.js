define(['jquery', 'youtube'], function ($, youtube) {

  $.fn.videoAttachment = function () {
    var $urlInput = $(this)
      , $formGroup = $urlInput.parent('.form-group')
      , $form = $urlInput.closest('form')
      , $preview = $formGroup.find('#preview-container');

    //additional fields
    var $title = $('<input name="video[title]" type="hidden" />').appendTo($form)
      , $vendor = $('<input name="video[vendor]" type="hidden" />').appendTo($form)
      , $vendor_id = $('<input name="video[vendor_id]" type="hidden" />').appendTo($form)
      , $thumbnail = $('<input name="video[thumbnail]" type="hidden">').appendTo($form);

    $urlInput.on('paste', function () {

      setTimeout(function () {
        var url = $urlInput.val()
          , youtubeId = youtube.parser(url);

        if (youtubeId) {

          $vendor_id.val(youtubeId);

          var src = 'http://www.youtube.com/embed/' + youtubeId + '?'
              + '&autohide=1' //autohide controls
              + '&showinfo=0' //disabled title & video author info
              + '&iv_load_policy=3' //disabled annotations
              + '&rel=0' //disable relevant videos on end
            ;

          $preview.html('<iframe src="' + src + '" width="560" height="315" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');

          youtube.info(youtubeId, function (info) {
            $title.val(info.title);
            $vendor.val('youtube');
            $thumbnail.val(info['thumbnail_url']);
          });
        }

      }, 100);
    });

  };
});