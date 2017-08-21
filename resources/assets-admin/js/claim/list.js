define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {
  
  $('#claims-list').entityList({
    removeUrl: '/admin/claim/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить жалобу :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });

});