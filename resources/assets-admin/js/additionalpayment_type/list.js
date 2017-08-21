define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $('#types-list').entityList({
    removeUrl: '/admin/AdditionalPaymentsType/remove',
    sortUrl: '/admin/AdditionalPaymentsType/sort',
    removeQuestion: __('Вы действительно хотите удалить вид выплат :title с сайта', {':title': '<strong class="text-nowrap">&laquo;{title}&raquo;</strong>'})
  });
});