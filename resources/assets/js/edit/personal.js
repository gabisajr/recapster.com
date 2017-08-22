define(['jquery', 'i18n', 'autosize', 'browser', 'fileupload', 'selectpicker', 'autocomplete'], function ($, __, autosize, browser) {

  var $form = $('form#edit-personal-form')
    , $submit = $form.find('.btn-submit')
    , $position = $form.find(':input#position')
    , $country = $form.find(':input#country')
    , $city = $form.find(':input#city')
    , $status = $form.find(':input#status');

  $form.find('select').selectpicker();
  if (browser.mobile) $form.find('select').selectpicker('mobile');

  autosize($form.find('textarea'));

  //загрузка аватарки
  (function () {
    var avatar = $form.find('img.avatar')
      , wrapper = avatar.closest('.wrapper')
      , loader = $('<div class="panel-loader"><img src="/images/loading.svg" class="loader"></div>').appendTo(wrapper).hide()
      , path = $form.find('input[name="avatar"]');

    $form.find('input#avatar').fileupload({
      url: '/upload/photo',
      beforeSend: function () {
        loader.fadeIn();
        $submit.prop('disabled', true);
        $.post('/upload/remove', {path: path.val()});
      },
      complete: function () {
        loader.fadeOut();
        $submit.prop('disabled', false);
      },
      done: function (e, data) {
        if (data.result.success) {
          path.val(data.result.path);
          avatar.attr('src', data.result.path);
        }
      }
    });

  })();

  //смена статуса
  $status.change(function () {
    var status = $(this).val()
      , $jobSettingsLink = $form.find('a.job-search-settings');
    if (status === 'search' || status === 'ready') {
      $jobSettingsLink.show();
    } else {
      $jobSettingsLink.hide();
    }
  });

  //при смене страны подгружаем список городов //todo live search
  $country.change(function () {
    var countryId = $(this).val();
    $.ajax({
      url: '/country/cities/' + countryId,
      type: 'POST',
      success: function (cities) {
        var options = '<option value="">' + __('Город') + '</option>';
        $.each(cities, function (index, city) {
          options += '\n<option value="' + city.id + '">' + city.title + '</option>';
        });
        $city.html(options).selectpicker('refresh');
      }
    })
  });

  $position.autocompletePosition();

});