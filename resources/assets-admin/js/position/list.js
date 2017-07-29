define(['jquery', 'i18n', 'entity-list', 'highlight'], function ($, __) {

  var list = $('#positions-list');

  list.entityList({
    removeUrl: '/admin/position/delete',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить профессию :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

  var q = $('#search-positions-form').find('input[name="q"]').val();
  if (q) list.find('.search-cell').highlight(q);

});