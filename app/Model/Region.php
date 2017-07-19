<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_City город
 *
 * @property int           id
 * @property string        alias
 * @property string        title
 *
 * @property Model_Country country
 * @property int           country_id
 *
 * @property ORM           cities
 */
class Region extends Model {

  public function country() {
    return $this->belongsTo('App\Model\Country');
  }

  public function cities() {
    return $this->hasMany('App\Model\City', 'region_id');
  }

  //todo form validation
  public function rules() {
    return [
      'title'      => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
      'country_id' => [
        ['not_empty'],
      ],
    ];
  }

  //public static function exists($id) {
  //  return ORM::factory('Region', $id)->loaded();
  //}
  //
  //public function delete() {
  //
  //  foreach ($this->cities->find_all() as $city) {
  //    $city->delete();
  //  }
  //
  //  return parent::delete();
  //}

//  public static function route_filter_alias($route, $params, $request) {
//
//    $alias = Arr::get($params, 'city_alias');
//    $city = ORM::factory('City', ['alias' => $alias]);
//    $request->city = $city;
//
//    if (!empty($alias)) return $city->loaded();
//
//    return null;
//  }


}