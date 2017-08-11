<?php

return [
  'client_id'        => '109018726151176',  # идентификатор Facebook приложения
  'client_secret'    => '22f5e67321cf0cd1d0a8a852fde7f4b5', # секретный ключ Facebook приложения
  'redirect_uri'     => "http://www.recapster.com/fbauth/verify", # путь на который Facebook перенаправит пользователя
  'url_access_token' => 'https://graph.facebook.com/v2.3/oauth/access_token', # путь по которому необходимо выполнить запрос для получения access_token (ключ доступа к данным пользователя)
  'url_auth'         => 'https://www.facebook.com/dialog/oauth',  # url страницы авторизации Facebook
  'url_debug_token'  => 'https://graph.facebook.com/debug_token', # url для дебаггинга токена (access_token)
  'group_url'        => 'https://www.facebook.com/recapster/', # группа Facebook
];