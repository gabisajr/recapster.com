define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#countries-list').entityList({
    removeUrl: '/admin/country/remove',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить страну :title с сайта', {
      ':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'
    })
  });

});