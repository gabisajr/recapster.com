/** Фильтр отвеченные|неотвеченные */
define(['jquery'], function ($) {

  $('input[type="checkbox"][name="answered"]').change(function () {
    if ($(this).is(':checked')) {
      $(this).closest('form').find('input[type="checkbox"][name="answered"]').prop('checked', false);
      $(this).prop('checked', true);
    }
  });

});