import '../main';
import $ from 'jquery';
import autosize from 'autosize';
import caretEnd from '../caretEnd';
import '../autocomplete';
import notify from '../notify';

let $form = $('form#experience-form')
  , $list = $form.find('.experience-list');

$form.find('.experience-form-group').each(function () {
  initExperienceItem($(this))
});

//добавить еще опыт
$form.find('.add-experience').click(function (e) {
  e.preventDefault();
  let newIndex = $form.find('.experience-form-group').length;
  $.get('/tmpl/user/edit/experience/item', {index: newIndex}, function (tmpl) {
    let $expGroup = $(tmpl);
    $list.append($expGroup);
    initExperienceItem($expGroup);
    $expGroup.find('input.companyTitle').focus();
  });
});

//delete experience item
$form.on('click', '.group-delete', function (e) {
  e.preventDefault();
  e.stopPropagation();

  let $delete = $(this);
  $delete.tooltip('dispose');
  $delete.closest('.group').remove();
  $.post('/experience/delete', $delete.data());
});

$form.submit(function (e) {
  let $submit = $form.find('[type="submit"]');
  e.preventDefault();

  $.ajax({
    url: $form.attr('action'),
    data: $form.serialize(),
    type: $form.attr('method'),
    beforeSend: function () {
      $submit.prop('disabled', true);
      $form.find('.is-invalid').removeClass('is-invalid').siblings('.invalid-feedback').remove();
    },
    complete: function () {
      $submit.prop('disabled', false);
    },
    error: function (res) {
      let errors = res.responseJSON.errors;
      // console.log(errors);
      $list.find('.experience-form-group').each(function () {
        $(this).find(':input').each(function () {
          let key = this.name
            .replace(/]\[/, '.')
            .replace(/]$/, '')
            .replace(/\[/, '.');

          let error = errors[key] ? errors[key][0] : null;

          if (error) {
            $(this).addClass('is-invalid').after('<div class="invalid-feedback">' + error + '</div>');
          }

        });
      });
    },
    success: function () {
      window.scrollTo(0, 0);
      notify.success(__("Your experience successfully saved"));
    }
  });
});

function initExperienceItem($group) {

  $('[data-toggle="tooltip"]').tooltip();

  $group.find('input.companyTitle').not('.ui-autocomplete-input').autocompleteCompany();
  $group.find('input.positionTitle').not('.ui-autocomplete-input').autocompletePosition();
  $group.find('input.cityTitle').not('.ui-autocomplete-input').autocompleteCity();

  let $cbIsCurrent = $group.find('input.isCurrent')
    , $endMonth = $group.find('select.endMonth')
    , $endYear = $group.find('select.endYear')
    , $text = $group.find('textarea.text')
    , $cbHasText = $group.find('input.hasText')
    , $textWrapper = $group.find('.text-wrapper');

  $text.focus(caretEnd);
  autosize($text);

  //отметил галочку "По настоящее время"
  $cbIsCurrent.change(function () {
    let checked = $(this).is(':checked');
    $endMonth.prop('disabled', checked).closest('.has-error').removeClass('has-error');
    $endYear.prop('disabled', checked).closest('.has-error').removeClass('has-error');
  });

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