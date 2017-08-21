/** Регистрация работодателя */
require(['/js/common.js'], function () {

  require(['jquery', 'applyAutocomplete'], function ($, applyAutocomplete) {

    var $form = $('form#signup-employers-form');
    if (!$form.length) return;

    //подгрузка полей для создания новой компании
    $form.on('click', '#complete-company-profile', function (e) {
      e.preventDefault();

      var $form = $(this).closest('form')
        , $company_title = $form.find('input[name="company_title"]').removeClass('error')
        , company_title = $company_title.val();

      $.get('/tmpl/partials/company-add-process', function (html) {
        var $el = $(html);
        var about = company_title.rus_about();
        $el.find('#tell-more-about-caption').text('Расскажите нам больше ' + about + ' ' + company_title);
        $('#company-add-process-wrap').hide().html($el.html()).fadeIn(function () {
          $(this).find('input[name="new_company[site]"]').focus();
        });

        applyAutocomplete();
      });

      $(this).closest('.text-error').remove();

    });

    //изменение названия компании
    $form.find('input.company.title')
      .keyup(function () {
        if (!$(this).val()) {
          $form.find('#company-add-process-wrap').html('');
        }
      })
      .change(function () {
        loadNewCompanyFields(this);
      });

  });

});