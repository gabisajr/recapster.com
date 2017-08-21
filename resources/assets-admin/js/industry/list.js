define(['jquery', 'i18n', '/js/admin/entity-list.js', 'highlight'], function ($, __) {

  var list = $('#industries-list');
  list.entityList({
    removeUrl: '/admin/industry/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить вид деятельности :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

  var q = $('form#search-form').find('input[name="q"]').val();
  if (q) list.find('.search-cell').highlight(q);

});