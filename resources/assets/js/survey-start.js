require(['/js/common.js'], function () {

  require(['jquery', 'BIT', 'SURVEY_TYPE'], function ($, BIT, SURVEY_TYPE) {

    var $form = $('form#survey-start-form');

    //выбор типа заявки
    $form.find('input[name="survey_type"]').change(function () {

      var survey_type = $(this).val();

      if (survey_type == SURVEY_TYPE.PHOTO || survey_type == SURVEY_TYPE.INTERVIEW) {
        $form.find('.job-status').addClass('hidden');
        $form.find('input[name="active_employee"][value="' + BIT.YES + '"]').click();
      } else {
        $form.find('.job-status').removeClass('hidden');
      }


      if (survey_type == SURVEY_TYPE.SALARY) {
        $form.find('.position-fieldset').removeClass('hidden');
        $form.find('.company-fieldset').addClass('hidden');

        $form.find('label#job-status-label').text('Статус работы');
        $form.find('label[for="active-employee-yes"]').text('Текущая работа');
        $form.find('label[for="active-employee-no"]').text('Бывшая работа');

        $form.find('input.company.title').attr('required', false);
        $form.find('input.position.title').attr('required', true).focus();

        window.xhrLoadNewCompanyFields && window.xhrLoadNewCompanyFields.abort();
        $form.find('#company-add-process-wrap').html('');

      } else {
        $form.find('.position-fieldset').addClass('hidden');
        $form.find('.company-fieldset').removeClass('hidden');

        $form.find('label#job-status-label').text('Статус работника');
        $form.find('label[for="active-employee-yes"]').text('Действующий');
        $form.find('label[for="active-employee-no"]').text('Бывшый');

        $form.find('input.position.title').attr('required', false);
        $form.find('input.company.title').attr('required', true).focus();
      }

    });

    function checkActiveEmployee() {

      var value = $form.find('input[name="active_employee"]:checked').val();

      if (value == BIT.YES) {
        $form.find('.job-ending-year').addClass('hidden');
        $form.find('select[name="last_year"]').val('').prop('required', false);
      } else {
        $form.find('.job-ending-year').removeClass('hidden');
        $form.find('select[name="last_year"]').prop('required', true);
      }
    }

    checkActiveEmployee();

    //выбор действующий | бывший сотрудник
    $form.find('input[name="active_employee"]').change(function () {
      checkActiveEmployee();
    });

    //фокусаут на поле название компани
    $form.find('input[name="company_title"]')
      .keyup(function () {
        if (!$(this).val()) $form.find('#company-add-process-wrap').html('');
      })
      .change(function () {
        loadNewCompanyFields(this);
      });

    $form.submit(function (e) {

      var $form = $(this);

      var survey_type = $form.find('input[name="survey_type"]:checked').val()
        , company_id = $form.find('input[name="company"]').val()
        || $form.find('input[type="radio"][name="company"]:checked').val()
        || null
        , want_create_company = $form.find('input[name="want_create_company"]').is(':checked');

      //рано отправлять форму, если хотим добавить не зарплату, если нет сущ. компании, или нет полей для новой компании
      if (survey_type != SURVEY_TYPE.SALARY && !company_id && !want_create_company) e.preventDefault();

    });

  });

});