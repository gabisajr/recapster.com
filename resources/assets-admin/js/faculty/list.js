define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#faculty-list').entityList({
    removeUrl: '/admin/faculty/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить факультет :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

});