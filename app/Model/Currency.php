<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 *
 * @property int    $id
 * @property string $code
 * @property string $title
 * @property string $symbol - символ волюты
 * @property string $short  - сокращеное название (тг, руб)
 * @property string $created_at
 * @property string $updated_at
 */
class Currency extends Model {

  protected $primaryKey = "code";


  //public static function exists($code) {
  //  return ORM::factory('Currency', $code)->loaded();
  //}

  /**
   * получить полулярные валюты
   *
   * @return Model_Currency[]
   */
  public function get_top_currencies() { //todo camelCase
    $top_currencies = ['KZT', 'EUR', 'USD', 'RUB'];

    return ORM::factory('Currency')
      ->where('code', 'IN', $top_currencies)
      ->select([DB::expr(
        "(IF(`code` = 'KZT', 4,
          IF(`code` = 'USD', 3,
          IF(`code` = 'EUR', 2,
          IF(`code` = 'RUB', 1, 0)))))"), 'priority_weight'])
      ->order_by('priority_weight', 'DESC')
      ->order_by('title')
      ->find_all();
  }

}