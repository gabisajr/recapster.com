define(['jquery', 'applyAutocomplete'], function ($, applyAutocomplete) {

  //<editor-fold desc="перерключение collapsible-блока">
  $(document).on('click', '.collapsible .toggle', function (e) {
    e.preventDefault && e.preventDefault();

    var $toggle = $(this);
    $toggle.toggleClass('opened');
    var slideMethod = $toggle.hasClass('opened') ? 'slideDown' : 'slideUp';
    $toggle.closest('.collapsible').find('.toggle-body')[slideMethod]();

  });
  //</editor-fold>

  //<editor-fold desc="Перекючение формы">
  require(['keyCodes'], function (keyCodes) {

    $(function () {

      function showForm($form) {
        $form.removeClass('hidden');
      }

      function hideForm($form) {
        $form.addClass('hidden').find('.multi-errors').remove();
        $form.find('input.error').removeClass('error');
      }

      $('form.esc-hide').keyup(function (e) {
        if (e.keyCode == keyCodes.ESC) hideForm($(this));
      });

      $('form .hide-form').click(function (e) {
        e.preventDefault();
        hideForm($(this).closest('form'));
      });

      $('.show-form').click(function (e) {
        e.preventDefault();
        var selector = $(this).data('target');
        showForm($(selector));
      });

    });

  });
  //</editor-fold>

  //<editor-fold desc="tooltips">
  $(document).ready(function () {
    require(['powerTip'], function () {

      $('.powertip').each(function () {
        var _this = $(this)
          , data = $(this).data()
          , placement = data['powertipPlacement'];

        _this.powerTip({
          placement: placement,
          smartPlacement: true
        });
      });

      //todo remove
      // $('.tooltip-confirmed-company-big').powerTip({placement: 'se-alt', smartPlacement: true, mouseOnToPopup: true});
      // $('.tooltip-anonymous-protection').powerTip({placement: 'nw'});
    });
  });
  //</editor-fold>

  //<editor-fold desc="кнопка загрузить больше">
  $('.btn-load-more').each(function () {

    return;

    var btn = $(this)
      , container = $(btn.data('target'))
      , data = btn.data()
      , skip = data.skip || 0
      , onScrollBound = false;

    btn.click(function (e) {
      e.preventDefault && e.preventDefault();
      container.trigger('load-more');
    });

    function bindOnScroll() {
      $(window).bind('scroll', scrollHandler);
      onScrollBound = true;
    }

    function unbindOnScroll() {
      $(window).unbind('scroll', scrollHandler);
      onScrollBound = false;
    }

    function scrollHandler() {
      var elTopFromWinTop = container.offset().top - $(window).scrollTop()
        , elBotFromWinTop = elTopFromWinTop + container.height()
        , bottomDiff = $(window).height() - elBotFromWinTop;
      if (bottomDiff > -100) container.trigger('load-more');
    }

    container.on('load-more', function () {

      if (container.data('blocked')) return;
      container.data('blocked', true);

      $.ajax({
        url: btn.data('href'),
        data: $.extend(data, {skip: skip}),
        type: 'post',
        beforeSend: function () {
          btn.html('Загрузить еще<i class="fa fa-refresh fa-spin marg-lt-sm preloader"></i>')
        },
        complete: function () {
          container.data('blocked', false);
        },
        success: function (res) {
          btn.remove();
          skip = res.skip || 0;
          container.append(res.html);
          if (!onScrollBound) bindOnScroll();

          //disable handlers
          if (!res['has_more'] && onScrollBound) {
            unbindOnScroll();
            container.off('load-more');
          }

        }
      });
    });

  });
  //</editor-fold>

  //<editor-fold desc="загрузить поля создания новой копании">
  (function () {

    window.loadNewCompanyFields = function (input) {

      var $company_input_title = $(input)
        , $form = $company_input_title.closest('form')
        , $company_input_id = $form.find('input[name="company"]')
        , $companyAddProcessWrap = $form.find('#company-add-process-wrap');

      //если пусто то ничего не делаем
      var company_title = $company_input_title.val();
      if (!company_title) return;

      //если уже выбрал компанию через автодоплнение - то ничего не делаем
      var companyId = $company_input_id.val();
      if (companyId) return;

      //подготовить фильтр
      var data = $company_input_title.data('filter') || {};
      data = $.extend({}, data, {company_title: company_title});

      window.xhrLoadNewCompanyFields = $.ajax({
        url: '/tmpl/partials/company-add-process',
        method: 'post',
        data: data,
        success: function (html) {
          $companyAddProcessWrap.html(html);
          applyAutocomplete();
        }
      });
    };

    //подгрузка полей для создания новой компании
    $(document).on('click', '#show-new-company-fields', function (e) {
      e.preventDefault();

      var $form = $(this).closest('form')
        , $company_title = $form.find('input[name="company_title"]')
        , company_title = $company_title.val();

      $.get('/tmpl/partials/new-company-fields', function (html) {
        var $el = $(html);

        var about = company_title.rus_about();
        $el.find('#tell-more-about-caption').text('Расскажите нам больше ' + about + ' ' + company_title);
        $('#company-add-process').html($el.html());

        applyAutocomplete();
      });
    });

  })();
  //</editor-fold>

  //<editor-fold desc="placeholder simulation for select">
  $(function () {

    $('select').bind('updateNotValue', function () {
      var select = $(this);
      select.val() ? select.removeClass('not-value') : select.addClass('not-value');
    }).trigger('updateNotValue');

    $(document).on('change', 'select', function () {
      $(this).trigger('updateNotValue');
    });

  });
  //</editor-fold>

  //<editor-fold desc="textarea maxlength && autosize">
  (function () {
    $('textarea[maxlength]')
      .wrap('<div class="maxlength-wrap"></div>')
      .before('<span class="minor gray maxlength-counter"></span>')
      .bind('updateCounter', updateCounter)
      .each(updateCounter)
      .keypress(updateCounter)
      .keyup(updateCounter);

    function updateCounter() {
      var $textarea = $(this)
        , $counter = $textarea.siblings('.maxlength-counter')
        , max = $textarea.attr('maxlength')
        , len = $textarea.val().length;

      $counter.text(len + ' из ' + max + ' символов');
    }

    require(['autosize'], function (autosize) {
      autosize($('textarea.autosize'));
    });
  })();
  //</editor-fold>

  //<editor-fold desc="close banner">
  (function () {
    $(document).on('click', '.banner-close', function (e) {
      e.preventDefault();
      e.stopPropagation();

      var banner = $(this).closest('.banner')
        , id = banner.attr('id');

      $.post('/banner/dismiss', {id: id});
      banner.slideUp(function () {
        banner.remove();
      });
    });
  })();
  //</editor-fold>

  //<editor-fold desc="close tip">
  (function () {
    $(document).on('click', '.close-tip', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var tip = $(this).closest('.tip');
      tip.slideUp(function () { tip.remove() });
    })
  })();
  //</editor-fold>

  require([
    'showMessageModal',
    'modal/alert',
    'search'
  ]);

});