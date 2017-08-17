require(['jquery', 'tplModalClose', 'fancybox'], function ($, tplModalClose) {

  var $form = $('form#edit-image-form')
    , $title = $form.find(':input[name="title"]')
    , $openModal = $('.open-edit-image-modal');

  //prepare modal
  $openModal.fancybox({
    padding: 0,
    fitToView: false,
    scrolling: 'visible',
    helpers: {
      overlay: {locked: false}
    },
    tpl: {closeBtn: tplModalClose},
    afterShow: function () {
      $title.focus();
    }
  });

  //set form params
  $(document).on('click', '.edit-image', function (e) {
    e.preventDefault();

    //set data to form
    var data = $(this).closest('.image-data').data();

    $form.find(':input[name="image"]').val(data['id']);
    $title.val(data['title']).trigger('updateCounter');
    $form.find(':input[name="city"]').val(data['city']);
    $form.find(':input[name="city_title"]').val(data['cityTitle']);
    $form.find('img.preview').attr('src', data['preview']);

    //open modal
    $openModal.click();

  });

});