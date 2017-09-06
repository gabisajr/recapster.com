<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\University
 *
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property string $site
 * @property int|null $country_id
 * @property int|null $city_id
 * @property int|null $logo_id
 * @property int|null $vk_id id университета ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Faculty[] $faculties
 * @property-read \App\Model\Image|null $logo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereLogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereVkId($value)
 * @mixin \Eloquent
 */
class University extends Model {

  public function country() {
    return $this->belongsTo('App\Model\Country');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function logo() {
    return $this->belongsTo('App\Model\Image');
  }

  public function faculties() {
    return $this->hasMany('App\Model\Faculty', 'university_id');
  }

  public function rules() { //todo validation
    return [
      'country_id' => [
        ['not_empty'],
      ],
      'city_id'    => [
        ['not_empty'],
      ],
      'alias'      => [
        [[$this, 'unique'], ['alias', ':value']],
      ],
      'title'      => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
      'site'       => [
        [[$this, 'unique'], ['site', ':value']],
      ],
      'vk_id'      => [
        [[$this, 'unique'], ['vk_id', ':value']],
      ],
    ];
  }

//  public function get($column) {
//    switch ($column) {
//      case 'url':
////        return "http://$_SERVER[HTTP_HOST]/edu/{$this->alias}/"; //todo
//        return $this->site;
//        break;
//      case 'of_university':
//        return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'Р') : $this->title;
//        break;
//    }
//    return parent::get($column);
//  }
// todo create observer
//  public function delete() {
//
//    //delete faculties
//    foreach ($this->faculties->find_all() as $faculty) $faculty->delete();
//
//    //delete logo
//    if ($this->logo->loaded()) $this->logo->delete();
//
//    return parent::delete();
//  }

}