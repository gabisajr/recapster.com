define(['jquery', 'i18n', 'country-cities', 'tagEditor'], function ($, __) {

  var form = $('form#company-form')
    , $companyId = $('input[name="company"]').val()
    , $industries = form.find(':input[name="industries"]');

  //добавить директора
  $('button[name="add-ceo"]').click(function () {
    $('#add-ceo-modal').modal();
  });

  //удалить директора
  $('button[name="remove-ceo"]').click(function () {
    $(this).closest('.director-panel').fadeOut(function () { $(this).remove() });
    $.post('/admin/company/removeCeo', {company: $companyId});
  });

  //направление автодополнение
  $industries.tagEditor({
    maxTags: 5,
    forceLowercase: false,
    placeholder: $industries.attr('placeholder'),
    autocomplete: {
      source: function (request, response) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '/autocomplete/industry',
          data: {filter: request.term},
          success: response
        });
      }
    }
  });


});