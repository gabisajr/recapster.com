<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Country страна
 *
 * @property int    $id
 * @property string $title      - название страны
 * @property string $iso_code   - ISO 3166-1 (Alpha-2) https://vk.com/dev/country_codes
 * @property int    $vk_id      - id страны ВКонтакте
 *
 * -------------------- virtual ----------------------------
 * @property string $of_country - родительный падеж название страны
 *
 * ------------------- has many ----------------------------
 * @property ORM    $cities     - города
 * @property ORM    $regions    - регионы страны (области, штаты, губернии)
 */
class Country extends Model {

  public function regions() {
    return $this->hasMany('App\Model\Region', 'country_id');
  }

  protected $_has_many = [
    'cities'  => [
      'model'       => 'City',
      'foreign_key' => 'country_id',
    ],
  ];

  public function filters() {
    return [
      true    => [
        ['trim'],
        [function ($value) {
          return (!$value) ? null : $value;
        }],
      ],
      'title' => [
        ['trim'],
      ],
    ];
  }

  public function rules() {
    return [
      'title'    => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
      'iso_code' => [
        [[$this, 'unique'], ['iso_code', ':value']],
      ],
      'vk_id'    => [
        [[$this, 'unique'], ['vk_id', ':value']],
      ],
    ];
  }

  //public function get($column) {
  //  switch ($column) {
  //    case 'of_country':
  //      return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'Р') : $this->title;
  //      break;
  //  }
  //  return parent::get($column);
  //}
  //
  //public function delete() {
  //  foreach ($this->cities->find_all() as $city) $city->delete();
  //  foreach ($this->regions->find_all() as $region) $region->delete();
  //
  //  return parent::delete();
  //}

  /** страны СНГ */
  public function cis() {

    $cis_codes = [
      'KZ', //Казахстан
      'RU', //Россия
      'UA', //Украина
      'AZ', //Азербайджан
      'AM', //Армения
      'BY', //Белоруссия
      'KG', //Киргизия
      'MD', //Молдавия
      'TJ', //Таджикистан
      'TM', //Туркмения
      'UZ', //Узбекистан
    ];

    $order = [];
    foreach ($cis_codes as $code) $order[] = "'{$code}'";
    $order = implode(',', $order);

    return ORM::factory($this->object_name())
      ->where('iso_code', 'IN', $cis_codes)
      ->order_by(DB::expr("field(iso_code, {$order})"))
      ->order_by('title')
      ->find_all();
  }

}