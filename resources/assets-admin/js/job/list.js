define(['jquery', 'i18n', 'entity-list'], function ($, __) {

  $('#jobs-list').entityList({
    removeUrl: '/admin/job/delete',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить вакансию :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });
});