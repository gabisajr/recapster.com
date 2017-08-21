define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#reviews-list').entityList({
    removeUrl: '/admin/review/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить отзыв :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });
  
});