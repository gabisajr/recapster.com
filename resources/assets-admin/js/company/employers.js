define(['jquery', 'i18n', '/js/admin/entity-list.js'], function ($, __) {

  $(function () {
    var $usersList = $('#users-list');
    $usersList.entityList({
      removeUrl: '/admin/user/remove',
      sortable: false,
      removeQuestion: __('Вы действительно хотите удалить пользователя :title с сайта', {
        ':title': '<strong class="text-nowrap">"{title}"</strong>'
      })
    });

    $usersList.on('click', 'button[name="request_email"]', function (e) {
      e.preventDefault();
      var user_id = $(this).closest('tr').data('id')
        , company_id = null //todo
        , company_title = null; //todo
      window.confirmModal(__('Пользователю будет отправлено письмо с просьбой выслать данные подтверждающие его связь с компанией :company', {':company': '<strong>' + company_title + '</strong>'}), function () {
        $.post('/admin/employers/requestEmail', {user: user_id, company: company_id}, function () {
          window.alertMessage(__('Письмо с запросом отправлено'), 'success');
        });
      });
    });

    $usersList.on('click', 'button[name="reset_password"]', function (e) {
      e.preventDefault();
      var user_id = $(this).closest('tr').data('id')
        , company_id = null; //todo
      window.confirmModal(__('Пользователю будет отправлено письмо с новым паролем, статус компании измениться на "Подтвержденый"'), function () {
        $.post('/admin/employers/confirm', {user: user_id, company: company_id}, function () {
          window.alertMessage(__('Письмо с новым паролем отправлено'), 'success');
        });
      });
    });
  });

});