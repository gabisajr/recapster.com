define(['jquery', 'autosize', 'caretEnd', 'select2', 'autocomplete', 'tagEditor'], function ($, autosize, caretEnd) {

  var $form = $('form#job-form')
    , $applyType = $form.find(':input[name="apply_type"]')
    , $groupContacts = $form.find('.form-group.contacts')
    , $groupExternalUrl = $form.find('.form-group.external_url')
    , $contacts = $groupContacts.find(':input[name="contacts"]')
    , $externalUrl = $groupExternalUrl.find(':input[name="external_url"]');

  $contacts.focus(caretEnd);
  $externalUrl.focus(caretEnd);
  autosize($contacts);

  $applyType.change(function () {
    var type = $(this).val();
    switch (type) {
      case 'contacts':
        $groupContacts.removeClass('hidden');
        $groupExternalUrl.addClass('hidden');
        autosize.update($contacts);
        $contacts.focus();
        break;
      case 'external':
        $groupExternalUrl.removeClass('hidden');
        $groupContacts.addClass('hidden');
        $externalUrl.focus();
        break;
      default:
        $groupExternalUrl.addClass('hidden');
        $groupContacts.addClass('hidden');
        break;
    }
  });

  // ajax select for companies
  $form.find('#job-company').select2({
    ajax: {
      url: "/company/search",
      cache: true,
      processResults: function (data) {
        return {
          results: data.items
        };
      }
    },
    minimumInputLength: 1
  });

  // ajax select for positions
  $form.find('#job-position').select2({
    ajax: {
      url: "/position/search",
      cache: true,
      processResults: function (data) {
        return {
          results: data.items
        };
      }
    },
    minimumInputLength: 3
  });

  $form.find('textarea#tags').tagEditor();

  $form.find('textarea#cities').tagEditor({
    maxTags: 5,
    forceLowercase: false,
    autocomplete: {
      source: function (request, response) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '/autocomplete/city',
          data: {filter: request.term},
          success: response
        });
      }
    }
  });

});