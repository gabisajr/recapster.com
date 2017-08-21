define(['jquery', 'i18n', '/js/admin/entity-list.js', 'highlight'], function ($, __) {

  var list = $('#morphers-list');

  list.entityList({
    removeUrl: '/admin/morpher/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить морфему :title из словаря', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

  var q = $('#search-morphers-form').find('input[name="qp"]').val();
  if (q) list.find('.search-cell').highlight(q);

});