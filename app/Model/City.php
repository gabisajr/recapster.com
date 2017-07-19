<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_City город
 *
 * @property int           $id
 * @property string        $alias
 * @property string        $title - название города
 * @property int           $vk_id - id города ВКонтакте
 *
 * ------------------- virtual -----------------------------
 * @property string        $of_city
 * @property string        $in_city
 *
 * ------------------- belongs to: -------------------------
 * @property Model_Country $country
 * @property int           $country_id
 *
 * @property Model_Region  $region
 * @property int           $region_id
 *
 * -------------------- has many: --------------------------
 * @property ORM           $universities
 */
class City extends Model {

  public function country() {
    return $this->belongsTo('App\Model\Country');
  }

  public function region() {
    return $this->belongsTo('App\Model\Region');
  }

  public function universities() {
    return $this->hasMany('App\Model\University', 'city_id');
  }

  public function filters() {
    return [
      true    => [
        ['trim'],
        [function ($value) {
          return (!$value) ? null : $value;
        }],
      ],
      'alias' => [
        ['trim'],
        ['mb_strtolower'],
        [function ($value) {
          return (!$value) ? null : $value;
        }],
      ],
    ];
  }

  public function rules() {
    return [
      'title'      => [
        ['not_empty'],

        //todo не получается уникальность так как с одинкоыми названияем в разных областях и районах
//        [[$this, 'unique'], ['title', ':value']],
      ],
      'alias'      => [
        ['regex', [':value', Regex::ALIAS]],
        [[$this, 'unique'], ['alias', ':value']],
      ],
      'country_id' => [
        ['not_empty'],
      ],
      'vk_id'      => [
        [[$this, 'unique'], ['vk_id', ':value']],
      ],
    ];
  }

  //public function get($column) {
  //  switch ($column) {
  //    case 'of_city':
  //      return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'Р') : $this->title;
  //      break;
  //    case 'in_city':
  //      return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'П') : $this->title;
  //      break;
  //  }
  //  return parent::get($column);
  //}

  //public static function exists($id) {
  //  return ORM::factory('City', $id)->loaded();
  //}

  public static function route_filter_alias($route, $params, $request) {

    $alias = Arr::get($params, 'city_alias');
    $city = ORM::factory('City', ['alias' => $alias]);
    $request->city = $city;

    if (!empty($alias)) return $city->loaded();

    return null;
  }

  /**
   * название относительно меня
   * Если я живу в той же стране что и город - тогда мне пойдет:
   * "Астана", а если я в другой стране, тогда "Астана, Казахстан"
   */
  public function title_regard_to_me() { //todo camelCase

    if (!$this->loaded()) return "<em class='text-muted'>(" . __('нет') . ")</em>";

    /** @var Model_User $curr_user */
    $curr_user = Auth::instance()->get_user();
    if ($curr_user && $curr_user->country->id == $this->country->id) {
      $title = __($this->title);
    } else {
      $title = __($this->title) . ", " . __($this->country->title);
    }

    return $title;

  }

}