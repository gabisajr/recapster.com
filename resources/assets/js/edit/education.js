import '../main';
import $ from 'jquery';
import 'select2';
import caretEnd from '../caretEnd';
import autosize from 'autosize';
import buildSelectOptions from '../buildSelectOptions';
import notify from '../notify';

notify.success("Ваше образование успешно сохранено");

let $form = $('form#education-form')
  , $list = $form.find('.education-list');

$form.find('.education-form-group').each(function () {
  initEducationItem($(this))
});

//добавить еще образование
$form.find('.add-education').click(function (e) {
  e.preventDefault();
  let newIndex = $form.find('.education-form-group').length;
  $.get('/tmpl/user/edit/education/item', {index: newIndex}, function (tmpl) {
    let $eduGroup = $(tmpl);
    $list.append($eduGroup);
    initEducationItem($eduGroup);
  });
});

//удалить образование
$form.on('click', '.group-delete', function (e) {
  e.preventDefault();
  e.stopPropagation();

  let $delete = $(this);
  $delete.tooltip('dispose');
  $delete.closest('.group').remove();
  $.post('/user/education/delete', $delete.data());
});

$form.submit(function (e) {
  e.preventDefault();

  let submit = $form.find('[type="submit"]');

  $.ajax({
    url: $form.attr('action'),
    data: $form.serialize(),
    type: $form.attr('method'),
    beforeSend: function () {
      submit.prop('disabled', true);
    },
    complete: function () {
      submit.prop('disabled', false);
    },
    success: function (res) {
      if (res.success) {
        window.scrollTo(0, 0);
        notify.success("Ваше образование успешно сохранено");
      }
    }
  });
});

function setEmpty() {
  $(arguments).each(function () {
    $(this).val('').html('');
  })
}

function show() {
  $(arguments).each(function () {
    $(this).show();
    $(this).find('select').select2({width: 'resolve'})
  });
}

function hide() { $(arguments).each(function () { $(this).hide() }) }

function initEducationItem($group) {

  $group.find('select').select2();
  $('[data-toggle="tooltip"]').tooltip();

  let $country = $group.find('select.country')
    , $city = $group.find('select.city')
    , $university = $group.find('select.university')
    , $faculty = $group.find('select.faculty')
    , $chair = $group.find('select.chair')
    , $eduForm = $group.find('select.edu_form')
    , $eduStatus = $group.find('select.status')
    , $startYear = $group.find('select.start_year')
    , $cbHasText = $group.find('input.has_text')
    , $text = $group.find('textarea.text');

  // form groups
  let $gCity = $city.closest('.form-group')
    , $gUniversity = $university.closest('.form-group')
    , $gFaculty = $faculty.closest('.form-group')
    , $gChair = $chair.closest('.form-group')
    , $gEduForm = $eduForm.closest('.form-group')
    , $gStatus = $eduStatus.closest('.form-group')
    , $gPeriod = $startYear.closest('.form-group')
    , $gText = $group.find('.text-group')
    , $textWrapper = $group.find('.text-wrapper');

  //on change county lazy load cities from this country which has one or more universities
  $country.change(function () {
    setEmpty($city, $university, $faculty, $chair);
    hide($gUniversity, $gFaculty, $gChair, $gEduForm, $gStatus, $gPeriod, $gText);

    let countryId = parseInt($(this).val());
    if (!countryId) $gCity.hide();

    let cities = graphql("/graphql")(`query { cities (country: ${countryId}, hasUniversities: true) {id, title} }`);
    cities().then(data => {
      let cities = data.cities;

      cities.length ? $gCity.show() : $gCity.hide();

      $city
        .html(buildSelectOptions(cities))
        .select2({width: 'resolve'});
    });
  });

  //on change city load universities from the city
  $city.change(function () {
    setEmpty($university, $faculty, $chair);
    hide($gFaculty, $gChair, $gEduForm, $gStatus, $gPeriod, $gText);

    let cityId = parseInt($(this).val());
    if (!cityId) $gUniversity.hide();

    let universities = graphql("/graphql")(`query { universities (city: ${cityId}) {id, title} }`);
    universities().then(data => {
      let universities = data.universities;

      universities.length ? $gUniversity.show() : $gUniversity.hide();

      $university
        .html(buildSelectOptions(universities))
        .select2({width: 'resolve'});
    });

  });

  //on change university load his faculties
  $university.change(function () {
    setEmpty($faculty, $chair);
    hide($gChair);

    let universityId = parseInt($(this).val());

    universityId ?
      show($gEduForm, $gStatus, $gPeriod, $gText) :
      hide($gFaculty, $gEduForm, $gStatus, $gPeriod, $gText);

    let faculties = graphql('/graphql')(`query { faculties (university: ${universityId}) {id, title} }`);
    faculties().then(data => {
      let faculties = data.faculties;

      faculties.length ? $gFaculty.show() : $gFaculty.hide();

      $faculty.html(buildSelectOptions(faculties))
        .select2({width: 'resolve'});

    });
  });

  //on change faculty load load his chairs (departments)
  $faculty.change(function () {
    setEmpty($chair);
    let facultyId = parseInt($(this).val());
    if (!facultyId) $gChair.hide();

    let chairs = graphql('/graphql')(`query { chairs (faculty: ${facultyId}) {id, title} }`);
    chairs().then(data => {
      let chairs = data.chairs;
      chairs.length ? $gChair.show() : $gChair.hide();

      $chair.html(buildSelectOptions(chairs))
        .select2({width: 'resolve'});

    });
  });

  $text.focus(caretEnd);
  autosize($text);

  //переклчить видимость текста
  $cbHasText.change(function () {
    let checked = $(this).is(':checked');
    if (checked) {
      $textWrapper.show();
      $text.focus();
    } else {
      $textWrapper.hide();
    }
  });

  return $group;
}