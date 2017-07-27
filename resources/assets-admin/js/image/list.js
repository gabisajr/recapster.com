define(['jquery', 'i18n', 'entity-list'], function ($, __) {

  $('table#images-list').entityList({
    removeUrl: '/admin/image/delete',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить фото :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });

});