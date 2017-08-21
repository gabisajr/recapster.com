define([
  'jquery',
  'json!/json/survey-text.json',
  'getAbsoluteUrl',
  'app_name'
], function ($, surveyText, getAbsoluteUrl, app_name) {

  var $form = $('form#global-form')
    , $survey_type = $form.find('input[name="survey_type"]')
    , $title = $form.find('h1.form-title');

  $survey_type.change(function () {
    var survey_type = $(this).val()
      , title = setTitle(survey_type)
      , url = $(this).closest('a.tab-link').attr('href');

    if (url) {
      history.replaceState(survey_type, title, getAbsoluteUrl(url));
      document.title = app_name + ' – ' + title;
    }
  });

  setTitle($survey_type.filter(':checked').val());

  function setTitle(survey_type) {
    var title = surveyText[survey_type].title;
    $title.text(title);
    return title;
  }

});