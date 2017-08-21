define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  var list = $('#posts-list')
    , sortable = false;

  list.entityList({
    removeUrl: '/admin/post/remove',
    sortable: sortable,
    sortUrl: '/admin/post/sort',
    removeQuestion: __('Вы действительно хотите удалить пост :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });

  list.find('button[name="blocked"]').click(function () {
    var btn = $(this)
      , blocked = btn.data('blocked') ? 0 : 1
      , id = btn.closest('tr').data('id');

    $.post('/admin/post/blocked', {id: id, blocked: blocked}, function (res) {
      btn.data('blocked', res.blocked)
        .find('span').text(res.blocked ? __('Разблокировать') : __('Блокировать'));
    });
  });
});