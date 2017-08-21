define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#salaries-list').entityList({
    removeUrl: '/admin/salary/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить зарплату :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });
});