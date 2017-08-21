define(['jquery', 'i18n', 'powertip', 'autosize', 'caretEnd', 'selectpicker'], function ($, __, powertip, autosize, caretEnd) {

  var form = $('form#education-form')
    , list = form.find('.education-list');

  form.find('.education-form-group').each(function () { eduGroup($(this)) });

  //добавить еще образование
  form.find('.add-education').click(function (e) {
    e.preventDefault();
    var newIndex = form.find('.education-form-group').length;
    $.post('/tmpl/edit/education/form-group', {index: newIndex}, function (tmpl) {
      list.append(eduGroup($(tmpl)));
    });
  });

  //удалить образование
  form.on('click', '.group-delete', function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).closest('.group').remove();
    $.post('/education/delete', $(this).data());
  });

  form.submit(function (e) {
    e.preventDefault();

    var submit = form.find('[type="submit"]');

    $.ajax({
      url: form.attr('action'),
      data: form.serialize(),
      type: form.attr('method'),
      beforeSend: function () {
        submit.prop('disabled', true);
      },
      complete: function () {
        submit.prop('disabled', false);
      },
      success: function (res) {
        if (res.success) {
          window.scrollTo(0, 0);
          window.location.reload();
        }
      }
    });
  });

  function buildOptions(items, female) {
    var empty = female ? __('Не выбрана') : __('Не выбран')
      , options = '<option value="">' + empty + '</option>';
    $.each(items, function (index, item) {
      options += '\n<option value="' + item.id + '">' + item.title + '</option>'
    });
    return options;
  }

  function setEmpty() { $(arguments).each(function () { $(this).val('').html('').selectpicker('refresh') }) }

  function show() { $(arguments).each(function () { $(this).show() }) }

  function hide() { $(arguments).each(function () { $(this).hide() }) }

  function eduGroup(group) {
    group.find('select').selectpicker();
    powertip(group.find('.powertip'));

    var country = group.find('select.country')
      , city = group.find('select.city')
      , university = group.find('select.university')
      , faculty = group.find('select.faculty')
      , chair = group.find('select.chair')
      , edu_form = group.find('select.edu_form')
      , status = group.find('select.status')
      , start_year = group.find('select.start_year')
      , end_year = group.find('select.end_year')
      , has_text = group.find('input.has_text')
      , text = group.find('textarea.text');

    var rCity = city.closest('.form-group')
      , rUniversity = university.closest('.form-group')
      , rFaculty = faculty.closest('.form-group')
      , rChair = chair.closest('.form-group')
      , rEduForm = edu_form.closest('.form-group')
      , rStatus = status.closest('.form-group')
      , rPeriod = start_year.closest('.form-group')
      , rText = group.find('.text-group')
      , textWrapper = group.find('.text-wrapper');

    //выбор страны
    country.change(function () {
      setEmpty(city, university, faculty, chair);
      hide(rUniversity, rFaculty, rChair, rEduForm, rStatus, rPeriod, rText);

      var countryId = $(this).val();
      if (!countryId) rCity.hide();
      $.get('/country/cities/' + countryId, {hasUniversity: true}, function (items) {
        city.html(buildOptions(items)).selectpicker('refresh');
        items.length ? rCity.show() : rCity.hide();
      });
    });

    //выбор города
    city.change(function () {
      setEmpty(university, faculty, chair);
      hide(rFaculty, rChair, rEduForm, rStatus, rPeriod, rText);

      var cityId = $(this).val();
      if (!cityId) rUniversity.hide();
      $.post('/city/universities/' + cityId, function (items) {
        university.html(buildOptions(items)).selectpicker('refresh');
        items.length ? rUniversity.show() : rUniversity.hide();
      });
    });

    //выбор университета
    university.change(function () {
      setEmpty(faculty, chair);
      hide(rChair);

      var universityId = $(this).val();

      universityId ?
        show(rEduForm, rStatus, rPeriod, rText) :
        hide(rFaculty, rEduForm, rStatus, rPeriod, rText);

      $.post('/university/faculties/' + universityId, function (items) {
        faculty.html(buildOptions(items)).selectpicker('refresh');
        items.length ? rFaculty.show() : rFaculty.hide();
      });
    });

    //выбор факультета
    faculty.change(function () {
      setEmpty(chair);
      var facultyId = $(this).val();
      if (!facultyId)rChair.hide();
      $.post('/faculty/chairs/' + facultyId, function (items) {
        chair.html(buildOptions(items, true)).selectpicker('refresh');
        items.length ? rChair.show() : rChair.hide();
      });
    });

    text.focus(caretEnd);
    autosize(text);

    //переклчить видимость текста
    has_text.change(function () {
      var checked = $(this).is(':checked');
      if (checked) {
        textWrapper.show();
        text.focus();
      } else {
        textWrapper.hide();
      }
    });

    return group;
  }

});