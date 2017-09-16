<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Model\UserExperience
 *
 * @property int $id
 * @property string|null $position_title название должности (без привязки)
 * @property int|null $position_id id должности
 * @property string|null $company_title название компании (без привязки)
 * @property int|null $company_id id компании
 * @property string|null $city_title название города (без привязки)
 * @property int|null $city_id id города
 * @property int|null $start_month начало работы, месяц
 * @property string|null $start_year начало работы, год
 * @property int|null $end_month окончание работы, месяц
 * @property string|null $end_year окончание работы, год
 * @property int $is_current работает по настоящее время
 * @property int|null $is_internship является ли стажировкой
 * @property string|null $text обязанности и достижения
 * @property int $user_id id пользователя
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Company|null $company
 * @property-read \App\Model\Position|null $position
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereCityTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereCompanyTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereEndMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereEndYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereIsInternship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereStartMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserExperience whereUserId($value)
 * @mixin \Eloquent
 */
class UserExperience extends Model {

  use Periodable;

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  public function company() {
    return $this->belongsTo('App\Model\Company');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  //public function rules() { //todo validation
  //  return [
  //    'company_title' => [
  //      [[$this, 'need_company_title'], [':value', ':validation', ':field']],
  //    ],
  //    'start_month'   => [
  //      ['not_future_month', [$this->start_year, ':value']],
  //    ],
  //    'start_year'    => [
  //      ['not_future_year'],
  //    ],
  //    'end_month'     => [
  //      ['not_future_month', [$this->end_year, ':value']],
  //
  //      //проверяем чтобы месяц окончания был не меньше месяца начала работы
  //      [function ($end_month, Validation $validation, $field) {
  //        if ($this->start_year && $this->end_year && ($this->start_year == $this->end_year) && $this->start_month && $end_month && ($end_month < $this->start_month)) {
  //          $validation->error($field, 'invalid');
  //        }
  //      }, [':value', ':validation', ':field']],
  //
  //    ],
  //    'end_year'      => [
  //      ['not_future_year'],
  //
  //      //проверяем чтобы год окончания работы не превышал год начала работы
  //      [function ($end_year, Validation $validation, $field) {
  //        if ($end_year && ($end_year < $this->start_year)) {
  //          $validation->error($field, 'invalid');
  //        }
  //      }, [':value', ':validation', ':field']],
  //
  //    ],
  //  ];
  //}

  //public function need_end($end_value, Validation $validation, $field) {
  //  if (!$this->is_current && !$end_value) {
  //    $validation->error($field, 'not_empty');
  //  }
  //}
  //
  //public function need_company_title($company_title, Validation $validation, $field) {
  //  if (!$this->company->loaded() && !$company_title) {
  //    $validation->error($field, 'not_empty');
  //  }
  //}

  //public function save(Validation $validation = null) {
  //
  //  if ($this->is_current) {
  //    $this->end_month = null;
  //    $this->end_year = null;
  //  }
  //
  //  if ($this->company_title && (!$this->company->loaded() || ($this->company->title != $this->company_title))) {
  //    $company = ORM::factory('Company')->where('company.title', 'LIKE', $this->company_title)->find();
  //    $this->company = $company;
  //  }
  //
  //  if ($this->position_title && (!$this->position->loaded() || ($this->position->title != $this->position_title))) {
  //    $position = ORM::factory('Position')->where('position.title', 'LIKE', $this->position_title)->find();
  //    $this->position = $position;
  //  }
  //
  //  if ($this->city_title && (!$this->city->loaded() || ($this->city->title != $this->city_title))) {
  //    $city = ORM::factory('City')->where('city.title', 'LIKE', $this->city_title)->find();
  //    $this->city = $city;
  //  }
  //
  //  return parent::save($validation);
  //}

  public function getReview() {

    $user = Auth::getUser();

    $query = Review::query()
      ->ofCompany($this->company)
      ->ofUser($this->user)
      ->latest();

    if (!$user || ($user->id != $this->user->id)) {
      $query->approved();
    }

    /** @var Review $review */
    $review = $query->first();

    return $review;
  }

  public function getCompanyTitle() {
    return $this->company ? $this->company->title : $this->company_title;
  }

  public function getPositionTitle() {
    return $this->position ? $this->position->title : $this->position_title;
  }

  public function getCityTitle() {
    return $this->city ? $this->city->title : $this->city_title;
  }

}