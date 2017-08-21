require(['/js/common.js'], function () {

  require(['jquery', 'BIT', 'showMessageModal', 'i18n'], function ($, BIT, showMessageModal, __) {

    var $form = $('form#add-salary-form')
      , $moneyFormat = $form.find('.money-format')
      , $inputBasePay = $form.find('input.base_pay')
      , $selectCurrency = $form.find('select.currency');

    //форматирование денег
    $inputBasePay.keyup(function () {
      $moneyFormat.trigger('update')
    });
    $selectCurrency.change(function () {
      $moneyFormat.trigger('update')
    });

    $moneyFormat.on('update', function () {
      var money = parseFloat($inputBasePay.val());
      $moneyFormat.text(money ? money.formatMoney(0, ',', ' ') + ' ' + $selectCurrency.val() : '');
    });

    //изменение есть/нет допвыплаты
    $form.find('input[name="has_additional_payments"]').change(function () {
      if ($(this).val() == BIT.YES) {
        $form.find('.additional-payments').removeClass('hidden');
      } else {
        $form.find('.additional-payments').addClass('hidden');
      }
    });

    var $companyAddProcessWrap = $form.find('#company-add-process-wrap');

    //изменение названия компании
    $form.find('input.company.title')
      .keyup(function () {
        if (!$(this).val()) {
          $companyAddProcessWrap.html('');
          $form.find('.job-status').addClass('hidden');
        }
      })
      .change(function () {
        loadNewCompanyFields(this);
      });

    $form.on('change', 'input[type="radio"][name="company"]', function () {
      $form.find('.job-status').removeClass('hidden');
    });

    //отметить флажок "Скрытый работодатель"
    $form.find('input[name="hidden_employer"]').change(function () {
      if ($(this).is(':checked')) {
        $form.find('.about-company').removeClass('hidden');
        $form.find('input.company').val('').prop('disabled', true);
        $form.find('input.company.title').removeClass('error');
        $form.find('img.logo.autocomplete').attr('src', '/images/empty-logo.jpg');
        $form.find('.job-status').addClass('hidden');
        $companyAddProcessWrap.html('');
      } else {
        $form.find('.about-company').addClass('hidden');
        $form.find('input.company').prop('disabled', false).focus();
      }
    });

    //перекючение действующий/бывший работник
    $form.find('input[name="active_employee"]').change(function () {
      if ($(this).val() == BIT.NO) {
        $form.find('.last-year').removeClass('hidden');
      } else {
        $form.find('.last-year').addClass('hidden');
      }
    });

    //отправка формы
    $form.submit(function (e) {

      var $form = $(this);

      var company_title = $form.find('input.company.title').val()
        , hidden_employer = $form.find('input[name="hidden_employer"]').is(':checked')
        , want_create_company = $form.find('input[name="want_create_company"]').is(':checked')
        , company_id = $form.find('input[name="company"]').val()
          || $form.find('input[type="radio"][name="company"]:checked').val()
          || null
        ;

      //рано отправлять форму, если нет сущ. компании, или нет полей для новой компании
      if (!hidden_employer && !company_id && !want_create_company) {
        e.preventDefault();

        if (!company_title) {
          showMessageModal(
            __('Введите название компании-работодателя или отметьте флажок "Я предпочитаю не указывать работодателя"'),
            __('Не хватает данных...'));
        }

      }

    });

  });

});