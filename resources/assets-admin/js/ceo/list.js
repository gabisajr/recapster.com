define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  var list = $('#persons-list');

  list.entityList({
    removeUrl: '/admin/ceo/remove',
    sortable: false,
    removeQuestion: __("Вы действительно хотите удалить CEO :title с сайта", {':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'})
  });

  var q = $('#search-persons-form').find('input[name="qp"]').val();
  if (q) list.find('.search-cell').highlight(q);
});