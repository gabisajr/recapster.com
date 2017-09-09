import $ from 'jquery';

let $header = $('#header')
  , $search = $header.find('.header-search')
  , $q = $search.find(':input.q');

if ($q.length) $q.autocomplete({
  source: function (request, response) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '/autocomplete/fast',
      data: {filter: request.term},
      success: response
    });
  }
}).autocomplete("instance")._renderItem = function (ul, item) {
  let li = $(item.html);
  li.find('.title').highlight(this.term);
  return li.appendTo(ul);
};

//banner
$('.banner-close').click(function () {
  let banner = $(this).closest('.banner'), id = banner.attr('id');
  $.post('/banner/dismiss', {id: id});
  banner.slideUp({
    progress: function () { $('.company-page-cover.with-cover-img').trigger('updateParallax') },
    complete: function () { banner.remove() }
  });
});

// tip
$('.close-tip').click(function () {
  let tip = $(this).closest('.tip')
    , tipId = tip.data('id');

  $.post('/tip/dismiss', {id: tipId});

  tip.slideUp({
    progress: function () { $('.company-page-cover.with-cover-img').trigger('updateParallax') },
    complete: function () { tip.remove() }
  });
});