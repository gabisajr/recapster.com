define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#regions-list').entityList({
    removeUrl: '/admin/region/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить регион :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

});