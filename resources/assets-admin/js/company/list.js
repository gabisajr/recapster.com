define(['jquery', 'i18n', 'entity-list', 'highlight'], function ($, __) {

  var $list = $('#companies-list');

  $list.entityList({
    removeUrl: '/admin/company/delete',
    sortable: false,
    removeQuestion: __('Вы действительно хотите удалить компанию1 :title с сайта', {
      ':title': '<strong class="text-nowrap">"{title}"</strong>'
    })
  });

  var search = $('#search-form').find('input[name="search"]').val();
  if (search) $list.find('.title-cell').highlight(search);
});