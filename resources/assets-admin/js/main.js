define(['jquery', 'ckfinder', 'ckeditor', 'i18n', 'alert-message', 'confirm-modal', 'autocomplete', 'notify'], function ($, CKFinder, CKEDITOR, __) {

  $.notify.defaults({position: 'top center'});

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': window.app.csrfToken
    }
  });


  CKFinder.setupCKEditor(null, '/ckfinder/');
  $('textarea[data-ckeditor]').each(function () {
    var textarea_id = $(this).attr('id');
    CKEDITOR.replace(textarea_id, {extraPlugins: 'justify'});
  });

  //remove image
  $('figure.image-upload-preview .delete').click(function () {
    var figure = $(this).closest('figure')
      , path = figure.data('path');
    $.post('/admin/image/remove', {path: path});
    figure.fadeOut(function () { figure.remove() });
  });


  //header company search
  $('#header-search-form').find('input[name="q"]').autocompleteCompany({
    use_link: true,
    admin_link: true
  });

  $(':input.autocomplete-company').autocompleteCompany();
  $(':input.autocomplete-user').autocompleteUser();

  //confirm delete entity
  $('form.delete-entity-form').submit(function (e, confirmed) {
    var form = $(this);
    if (!confirmed) {
      e.preventDefault();
      window.confirmModal(__('Подтвердите удаление'), function () {
        form.trigger('submit', true);
      });
    }
  });

  (function () {
    var $select = $('.select2');
    if ($select.length) requirejs(['select2'], function () {
      $select.select2();
    });
  })();

  //textarea autosize
  (function () {
    var $ta = $('textarea.autosize');
    if ($ta.length) requirejs(['autosize'], function (autosize) {
      autosize($ta);
    });
  })();


  // $('input[name="video[url]"]').videoAttachment();

});