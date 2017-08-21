define(['jquery', 'initTiny', 'autocomplete'], function ($, initTiny) {

  initTiny();
  
  var form = $('form#experience-form');

  form.find('input#company').autocompleteCompany();
  form.find('input#position').autocompletePosition();
  form.find('input#city').autocompleteCity();

});