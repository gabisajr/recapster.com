define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {
  $('#city-list').entityList({
    removeUrl: '/admin/city/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить город :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });
});