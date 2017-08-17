<?php

namespace App;

class UserJobStatus {

  const NOT_SEARCH = 'not_search';
  const SEARCH = 'search';
  const READY = 'ready';

  public static function getStatuses() {
    return [
      self::NOT_SEARCH => __('Не ищу работу'),
      self::SEARCH     => __('Ищу работу'),
      self::READY      => __('Открыт к предложениям'),
    ];
  }

}