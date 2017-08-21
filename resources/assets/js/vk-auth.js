//todo next iteration
//<editor-fold desc="Авторизация ВКонтакте">
//$(function () {
//
//  /** @see https://vk.com/dev/permissions */
//  var vk_auth_settings = 0;
//  var offline = 65536;
//  var email = 4194304;
//  var nohttps = 0;
//
//  vk_auth_settings += offline + nohttps + email;
//
//  $('.btn-vk-login').click(function (e) {
//    e.preventDefault();
//
//    VK.Auth.login(function (response) {
//
//      if (response.session) {
//
//        /* Пользователь успешно авторизовался */
//        console.log('user success logged by vk open api');
//        location.reload();
//
//      } else {
//        /* Пользователь нажал кнопку Отмена в окне авторизации */
//        console.log('user canceled vk auth');
//      }
//    }, vk_auth_settings);
//
//  });
//
//});
//</editor-fold>