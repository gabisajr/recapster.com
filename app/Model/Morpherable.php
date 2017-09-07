<?php

namespace App\Model;

use App;

trait Morpherable {

  /**
   * родительный падеж: кого? чего?
   * @param string $field
   * @return string
   */
  public function of(string $field) {
    if (App::isLocale('ru')) {
      Morpher::inflect($this->{$field}, 'Р');
    }
    return $this->{$field};
  }

  /**
   * родительный падеж: для кого? для чего?
   * @param string $field
   * @return string
   */
  public function for(string $field) {
    return $this->of($field);
  }

  /**
   * предложный падеж: О ком? О чем?
   * @param string $field
   * @return string
   */
  public function about(string $field) {
    if (App::isLocale('ru')) {
      return Morpher::inflect($this->{$field}, 'П');
    }
    return $this->{$field};
  }

}