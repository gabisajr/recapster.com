define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#interviews-list').entityList({
    removeUrl: '/admin/interview_question/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить вопрос собеседования :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });
});