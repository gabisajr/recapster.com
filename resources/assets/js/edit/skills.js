define(['jquery', 'powertip', 'keyCodes', 'jquery-ui', 'highlight'], function ($, powertip, keyCodes) {

  var form = $('form#edit-skills-form')
    , skillsList = form.find('.skills-list')
    , langsList = form.find('.langs-list');

  var skillInputs = skillsList.find('input.title').keydown(skillKeydown);
  skillInputs.each(function (index, input) { skillAutocomplete(input) });

  var langInputs = langsList.find('input.title').keydown(langKeydown);
  langInputs.each(function (index, input) { langAutocomplete(input) });

  form.find('.add-skill').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    addSkill();
  });

  form.find('.add-lang').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    addLang();
  });

  function addSkill() {
    var newIndex = form.find('.form-group-skill').length;
    $.post('/tmpl/edit/skills/form-group', {index: newIndex}, function (tmpl) {
      var formGroup = $(tmpl).appendTo(skillsList)
        , input = formGroup.find('input.title');

      input.keydown(skillKeydown);
      skillAutocomplete(input[0]);

      powertip(formGroup.find('.powertip'));
      input.focus();
    });
  }

  function addLang() {
    var newIndex = form.find('.form-group-lang').length;
    $.post('/tmpl/edit/skills/form-group-lang', {index: newIndex}, function (tmpl) {
      var formGroup = $(tmpl).appendTo(langsList)
        , input = formGroup.find('input.title');

      input.keydown(langKeydown);
      langAutocomplete(input[0]);

      powertip(formGroup.find('.powertip'));
      input.focus();
    });
  }

  function skillKeydown(e) {
    if ((e.keyCode == keyCodes.ENTER)) {
      if ($(this).val().trim()) addSkill();
      e.preventDefault();
      return false;
    }
  }

  function langKeydown(e) {
    if ((e.keyCode == keyCodes.ENTER)) {
      if ($(this).val().trim()) addLang();
      e.preventDefault();
      return false;
    }
  }

  form.on('click', '.delete-skill', function () {
    var formGroup = $(this).closest('.form-group');
    formGroup.remove();
    $.post('/skill/delete', $(this).data());
  });

  form.on('click', '.delete-lang', function () {
    var formGroup = $(this).closest('.form-group');
    formGroup.remove();
    $.post('/lang/delete', $(this).data());
  });

  form.submit(function (e) {

    //check set level
    form.find('.form-group-lang').each(function () {
      var langGroup = $(this)
        , inTitle = langGroup.find(':input.title')
        , inLevel = langGroup.find(':input.level')
        , title = inTitle.val()
        , level = inLevel.val();

      if (title && !level) {
        inLevel.focus().parent().addClass('has-error');
        e.preventDefault();
      }
    });
  });

  langsList.on('change', ':input.level', function () {
    if ($(this).val()) {
      $(this).parent().removeClass('has-error');
    }
  });


  function skillAutocomplete(input) {
    input = $(input);

    var exceptSkills = [];
    skillsList.find('input.title').each(function (index, input2) {
      var val = input2.value.trim();
      if (input !== input2 && val) {
        exceptSkills.push(val);
      }
    });

    input.autocomplete({
      minLength: 2,
      source: function (request, response) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '/autocomplete/skill',
          data: {filter: request.term, except: exceptSkills},
          success: response
        });
      }
    }).autocomplete("widget").addClass("sm");

    input.autocomplete("instance")._renderItem = function (ul, item) {
      return $('<li>').append(item.label).highlight(this.term).appendTo(ul);
    };
  }

  function langAutocomplete(input) {
    input = $(input);

    var exceptLangs = [];
    langsList.find('input.title').each(function (index, input2) {
      var val = input2.value.trim();
      if (input !== input2 && val) {
        exceptLangs.push(val);
      }
    });

    input.autocomplete({
      minLength: 2,
      source: function (request, response) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '/autocomplete/lang',
          data: {filter: request.term, except: exceptLangs},
          success: response
        });
      }
    }).autocomplete("widget").addClass("sm");

    input.autocomplete("instance")._renderItem = function (ul, item) {
      return $('<li>').append(item.label).highlight(this.term).appendTo(ul);
    };
  }


});