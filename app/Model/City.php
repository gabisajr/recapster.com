<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\City
 *
 * @property int $id
 * @property string|null $alias
 * @property string $title название города
 * @property int|null $country_id
 * @property int|null $region_id
 * @property int|null $vk_id id города ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Company[] $companies
 * @property-read \App\Model\Country|null $country
 * @property-read \App\Model\Region|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\University[] $universities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City hasActiveCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereVkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City withActiveCompaniesCount()
 * @mixin \Eloquent
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

  public function companies() {
    return $this->hasMany('App\Model\Company', 'hq_city_id');
  }

  /**
   * Scope a query to only cities, which are has active companies
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeHasActiveCompanies($query) {
    return $query->whereHas('companies', function ($query) {
      $query->active();
    });
  }

  /**
   * Scope a query to only cities, which are has active companies, set active_companies_count attribute
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeWithActiveCompaniesCount($query) {
    return $query->withCount([
      'companies as active_companies' => function ($query) {
        $query->active();
      },
    ]);
  }

  public function filters() {
    return [
      'alias' => [
        ['trim'],
        ['mb_strtolower'], //todo filter
        [function ($value) {
          return (!$value) ? null : $value;
        }],
      ],
    ];
  }

  public function rules() { //todo validation
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

    if (!empty($alias)) return $city->exists;

    return null;
  }

  /**
   * название относительно меня
   * Если я живу в той же стране что и город - тогда мне пойдет:
   * "Астана", а если я в другой стране, тогда "Астана, Казахстан"
   */
  public function titleRegardToMe() { //todo camelCase

    if (!$this->exists) return "<em class='text-muted'>(" . __('нет') . ")</em>";

    $currUser = \Auth::user();
    if ($currUser && $currUser->country->id == $this->country->id) {
      $title = __($this->title);
    } else {
      $title = __($this->title) . ", " . __($this->country->title);
    }

    return $title;

  }

}