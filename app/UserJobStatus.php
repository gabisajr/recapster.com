<?php

namespace App;

class UserJobStatus {

  const NOT_LOOKING = 'not_looking';
  const ACTIVE = 'active';
  const PASSIVE = 'passive';

  public static function getStatuses() {
    return [
      self::ACTIVE      => __('Активно ищу работу'),
      self::PASSIVE     => __('Открыт к предложениям, но не активно ищу'),
      self::NOT_LOOKING => __('Не ищу работу'),
    ];
  }

}