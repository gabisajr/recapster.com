define(['jquery', 'add-form', 'browser'], function ($, initForm, browser) {

  var username = $('head').data('username');
  var addForm = $('form#add-form');
  addForm.addClass('focus');

  if (!browser.mobile) {
    addForm.find(':input.title').focus();
  }

  initForm(addForm, function () {
    location.href = '/' + username + '/activity'
  });

});