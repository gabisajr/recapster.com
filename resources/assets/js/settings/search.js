define(['jquery', 'autocomplete'], function ($) {
  var form = $('form#job-preferences-form');
  form.find('input#position').autocompletePosition();
  form.find('input#city').autocompleteCity();
});