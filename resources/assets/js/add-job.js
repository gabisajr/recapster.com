require(['/js/common.js'], function () {

  require([
    'jquery'
    , 'tinyMCE'
    , 'fancytree'
    , 'fancytree-glyph'
    , 'perfect-scrollbar'
    , 'fancybox'
    , 'tagEditor'
    , 'inputmask'], function ($, tinyMCE) {

    var $form = $('form#add-job-form');

    if (!$form.length) return;

    //money format
    $form.find('input[data-inputmask-regex]').inputmask('Regex');

    //<editor-fold desc="всплывающие подсказки">
    $form.find('.show-help').focus(function () {
      var id = $(this).attr('id')
        , $help = $('.field-help[data-for="' + id + '"]');
      if (id && $help.length) $help.fadeIn();
    }).focusout(function () {
      $('.field-help').hide();
    });

    $form.find('#salary-container').find(':input').focus(function () {
      var id = 'salary-container'
        , $help = $('.field-help[data-for="' + id + '"]');
      if (id && $help.length) $help.fadeIn();
    }).focusout(function () {
      $('.field-help').hide();
    });
    //</editor-fold>

    //<editor-fold desc="html-редактор">
    tinyMCE.init({
      selector: 'textarea.tinymce',
      mode: "textareas",
      theme: "modern",
      plugins: "link autoresize paste",
      paste_as_text: true,
      height: 150,
      autoresize_bottom_margin: 0,
      autoresize_min_height: 150,
      autoresize_max_height: 500,
      statusbar: false,
      browser_spellcheck: true,
      convert_newlines_to_brs: false,
      force_p_newlines: false,
      menubar: false,
      target_list: false,
      skin: 'lightgray',
      language: 'ru',
      toolbar: "bold,italic,link,|,bullist,numlist,|,outdent,indent",
      setup: function (ed) {

        ed.on('focus', function (focused) {

          //hide others help tooltips
          $('.field-help:visible').not("[data-for='" + focused.target.id + "']").hide();

          //show help tooltip for editor
          var help = $(".field-help[data-for='" + focused.target.id + "']");
          if (help.is(":visible")) return;
          if (help.length) help.fadeIn();

        });

        ed.on('blur', function (blurred) {
          var help = $(".field-help[data-for='" + blurred.target.id + "']");
          if (help.length) help.hide();
        });

      },
      content_css: '/css/tiny-content.css'
    });
    //</editor-fold>

    //<editor-fold desc="Теги">
    (function () {
      var $taTags = $form.find('textarea#tags')
        , maxTags = $taTags.data('max-tags') || 5
        , placeholder = $taTags.attr('placeholder')
        , $help = $('.field-help[data-for="tags"]');

      $taTags.tagEditor({
        placeholder: placeholder,
        maxTags: maxTags,
        maxLength: 30
      }); //todo autocomplete

      $form.on('focus', '.tags-w :input', function () {
        $help.fadeIn();
      });

      $("*:not(.tag-editor)").on("click", function () {
        if ($help.is(':visible')) $help.hide();
      });

    })();
    //</editor-fold>

  });

});