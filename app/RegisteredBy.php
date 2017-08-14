<?php

namespace App;

class RegisteredBy {

  const WEB_APP = 'web_app';       # сайт
  const MOBILE_APP = 'mobile_app'; # мобильное приложение
  const VK = 'vk';                 # ВКонтакте
  const FACEBOOK = 'facebook';     # Facebook
  const GOOGLE = 'google';         # Google
  const OK = 'ok';                 # Одноклассники

  /**
   * Получить строку через что зарагистрировался "Через …"
   * @param $key
   * @return null|string
   */
  public static function getAcrossCaption($key) {

    $across_caption = null;

    switch ($key) {

      case static::VK:
        $across_caption = __('через ВКонтакте');
        break;

      case static::FACEBOOK:
        $across_caption = __('через Facebook');
        break;

      case static::GOOGLE:
        $across_caption = __('через Google');
        break;

      case static::MOBILE_APP:
        $across_caption = __('через мобильное приложение');
        break;

      case static::OK:
        $across_caption = __('через Одноклассники');
        break;

      case static::WEB_APP:
        $across_caption = __('через сайт');
        break;

      default:
        $across_caption = __('через неизвестный источник');
        break;
    }

    return $across_caption;

  }

}