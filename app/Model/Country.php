<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Country
 *
 * @property int $id
 * @property string $title
 * @property string|null $iso_code ISO 3166-1 alpha-2
 * @property int|null $vk_id id страны ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Region[] $regions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country cIS()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereVkId($value)
 * @mixin \Eloquent
 */
class Country extends Model {

  public function regions() {
    return $this->hasMany('App\Model\Region', 'country_id');
  }

  public function cities() {
    return $this->hasMany('App\Model\City', 'country_id');
  }

  public function rules() { //todo validation
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
  //public function delete() { //todo observer
  //  foreach ($this->cities->find_all() as $city) $city->delete();
  //  foreach ($this->regions->find_all() as $region) $region->delete();
  //
  //  return parent::delete();
  //}

  /**
   * Scope a query to only countries from CIS Union
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeCIS($query) {

    $cisCodes = [
      'KZ', //Kazakhstan
      'RU', //Russia
      'UA', //Ukraine
      'AZ', //Azerbaijan
      'AM', //Armenia
      'BY', //Belarus
      'KG', //Kyrgyzstan
      'MD', //Moldova
      'TJ', //Tajikistan
      'TM', //Turkmenistan
      'UZ', //Uzbekistan
    ];

    $order = [];
    foreach ($cisCodes as $code) $order[] = "'{$code}'";
    $order = implode(',', $order);

    return $query->whereIn('countries.iso_code', $cisCodes)
      ->orderByRaw("FIELD(countries.iso_code, {$order})");
  }

}