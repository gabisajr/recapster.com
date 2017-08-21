define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#interviews-list').entityList({
    removeUrl: '/admin/interview/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить собеседованние :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });
});