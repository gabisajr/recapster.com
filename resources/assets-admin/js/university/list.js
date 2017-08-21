define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#universities-list').entityList({
    removeUrl: '/admin/university/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить учебное заведение :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

});