define(['jquery', 'i18n', 'browser', 'fileupload', 'autocomplete', 'select2'], function ($, __) {

  var $form = $('form#edit-personal-form')
    , $submit = $form.find('.btn-submit')
    , $position = $form.find(':input#position')
    , $country = $form.find(':input#country')
    , $city = $form.find(':input#city')
    , $status = $form.find(':input#status');

  //загрузка аватарки
  (function () {
    var $avatar = $form.find('img.avatar')
      , $wrapper = $avatar.closest('.wrapper')
      , $loader = $('<div class="panel-loader"><img src="/images/loading.svg" class="loader"></div>').appendTo($wrapper).hide();

    $form.find('input#avatar').fileupload({
      url: '/user/avatar/upload',
      beforeSend: function () {
        $loader.fadeIn();
      },
      complete: function () {
        $loader.fadeOut();
      },
      done: function (e, data) {
        $avatar.attr('src', data.result);
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

  $country.select2({
    placeholder: __("Выберите страну")
  }).on('select2:opening', function () {
    $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', __('Начните набирать') + '…');
  });

  $city.select2({
    placeholder: __("Выберите город")
  }).on('select2:opening', function () {
    $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', __('Начните набирать') + '…');
  });

  //при смене страны подгружаем список городов
  $country.change(function () {
    var countryId = $(this).val();
    $.ajax({
      url: '/country/cities',
      data: {country: countryId},
      type: 'post',
      success: function (cities) {
        var options = '<option value="">' + __('Город') + '</option>';
        $.each(cities, function (index, city) {
          options += '\n<option value="' + city.id + '">' + city.title + '</option>';
        });
        $city.html(options);
      }
    })
  });

  $position.autocompletePosition();

});