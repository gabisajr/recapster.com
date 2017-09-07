<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\University
 *
 * @property int $id
 * @property string $slug
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University ofCity($city)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereLogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\University whereSlug($value)
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

  /**
   * Scope a query to only universities, which are locate in $city
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param int|City $city
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfCity($query, $city) {

    $cityId = null;

    if ($city instanceof City) {
      $cityId = $city->id;
    } elseif (is_numeric($city)) {
      $cityId = $city;
    } else {
      error_log("invalid country argument: value '$city', needs City or int");
    }

    if ($cityId) {
      $query->where('universities.city_id', '=', $cityId);
    }

    return $query;
  }

  public function rules() { //todo validation
    return [
      'country_id' => [
        ['not_empty'],
      ],
      'city_id'    => [
        ['not_empty'],
      ],
      'slug'      => [
        [[$this, 'unique'], ['slug', ':value']],
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
////        return "http://$_SERVER[HTTP_HOST]/edu/{$this->slug}/"; //todo
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