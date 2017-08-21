define(['jquery', 'i18n'], function ($, __) {

  //load country's cities
  $('select#country').change(function () {
    var form = $(this).closest('form')
      , citySelect = form.find('select#city')
      , countryId = $(this).val();

    $.post('/admin/country/cities/' + countryId, function (cities) {
      var options = '<option value="">' + __('Город') + '</option>';
      $.each(cities, function (index, city) {
        options += '\n<option value="' + city.id + '">' + city.title + '</option>';
      });
      citySelect.html(options).prop('disabled', !cities.length).selectpicker('refresh');
    });
  });

});