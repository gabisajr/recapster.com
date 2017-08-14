define(['jquery', 'i18n', 'highlight', 'entity-list'], function ($, __) {

  var $list = $('#users-list');
  $list.entityList({
    removeUrl: '/admin/user/delete',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить пользователя :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });

  var search = $('#search-users-form').find('input[name="search"]').val();
  if (search) $list.find('.search-cell').highlight(search);
});