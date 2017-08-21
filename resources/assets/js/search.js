define(['jquery', 'post/job', 'post/review', 'post/company', 'highlight'], function ($) {

  var form = $('form.search-form')
    , foundCount = form.closest('.panel').find('.found-count')
    , btnReset = form.find(':input[type=reset]')
    , qInput = form.find(':input[name=q]')
    , results = $('.search-results')
    , btnLoadMore = $('.btn-load-more')
    , type = form.find('input[name=type]').val();

  highlight();

  results.find('.job-post').jobPost();
  results.find('.review-post').reviewPost();
  results.find('.company-post').companyPost();

  form.submit(function (e) {
    e.preventDefault();
    search($(this).serializeArray());
  });

  form.find(':radio').on('change', function (e) {

    var name = $(this).attr('name')
      , input = form.find(':radio[name="' + name + '"]').filter(':checked')
      , title = input.data('title')
      , val = input.val()
      , toggle = input.closest('.dropdown').find('.dropdown-toggle');

    if (val) {
      toggle.addClass('has-value').find('.title').text(title);
    } else {
      toggle.removeClass('has-value').find('.title').text(toggle.data('title'));
    }

    if (name == 'type') {
      window.location.href = '/search?type=' + val;
      return;
    }

    btnReset.hide();
    form.find(':radio').not('[name="sort"], [name="type"]').filter(':checked').each(function () {
      if ($(this).val()) btnReset.show();
    });

    if (!e.isTrigger) {
      form.submit();
      $('.mobile-filter').find(':radio[name="' + name + '"][value="' + val + '"]').prop('checked', true).trigger('click');
    }
  });

  btnReset.click(function (e) {

    e.preventDefault();
    e.stopPropagation();

    form.find(':radio[value=""]').prop('checked', true).trigger('change');
    $('.mobile-filter').find(':radio[value=""]').prop('checked', true).trigger('click');
    // form.find('input[name="sort"]').eq(0).prop('checked', true).trigger('change');


    btnReset.hide();
    form.submit();
  });

  btnLoadMore.click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    var data = form.serializeArray();
    data.push({name: 'skip', value: results.find('.search-post').length});
    search(data, true);
  });

  //выполнить поиск
  function search(data, loadMore) {
    $.ajax({
      url: form.attr('action'),
      type: 'post',
      data: data,
      beforeSend: function () {
        btnLoadMore.prop('disabled', true);
        if (!loadMore) {
          var new_url = '/search?' + $.param(data);
          window.history.replaceState({}, document.title.toString(), new_url);
        }
      },
      complete: function () {
        btnLoadMore.prop('disabled', false);
      },
      success: function (res) {

        var newResults = $(res.results);
        newResults.find('.job-post').jobPost();
        newResults.find('.review-post').reviewPost();
        newResults.find('.company-post').companyPost();

        loadMore ? results.append(newResults) : results.html(newResults);

        foundCount.text(res.found);
        res.found_count ? foundCount.show() : foundCount.hide();
        highlight();

        res.has_more ? btnLoadMore.show() : btnLoadMore.hide();
      }
    });
  }

  function highlight() {
    var q = qInput.val();
    results.highlight(q, {caseSensitive: false});
  }

  //mobile filters
  require(['mobile-view'], function () {

    var filter = $('#mobile-filter')
      , field = filter.find('[data-filter]')
      , btnOpenFilter = form.find('.mobile-filter-open');

    //открыть фильтр
    btnOpenFilter.click(function () {
      filter.mobileView('open');
    });

    filter.mobileView('option', 'beforeClose', function () {
      var count = $('.mobile-filter :radio:checked').filter(function () { return this.value }).length;
      count ? btnOpenFilter.addClass('has-value') : btnOpenFilter.removeClass('has-value');
    });

    //открыть список
    field.click(function () {
      var name = $(this).data('filter');
      $('#mobile-filter-' + name).mobileView('open');
    });

    //применить фильтр
    filter.find('.apply-filter').click(function () {
      field.each(function () {
        var th = $(this)
          , name = th.data('filter')
          , value = th.find('.value').data('value') || '';

        form.find(':radio[name="' + name + '"][value="' + value + '"]').prop('checked', true).change();
      });
      form.submit();

      filter.mobileView('close');
    });

    //сбросить фильтр
    filter.find('.reset').click(function () {
      btnReset.click();
      filter.mobileView('close');
    });

    //выбор значения в списке
    $('.mobile-filter').each(function () {
      var _filter = $(this)
        , radio = _filter.find(':radio')
        , li = _filter.find('li')
        , name = radio.attr('name');

      radio.click(function () {
        var item = radio.filter(':checked')
          , val = item.val()
          , title = item.data('title');

        var value = filter.find('[data-filter="' + name + '"]').find('.value');
        value.text(title).data('value', val);
        val ? value.addClass('has-value') : value.removeClass('has-value');

        _filter.mobileView('close');
      });

    });

  });

});