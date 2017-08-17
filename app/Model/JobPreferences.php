<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\JobPreferences - предпочтения пользователя по работе
 *
 * @property int $id
 * @property int $user_id id пользователя
 * @property int|null $position_id id должности
 * @property string|null $position_title название должности
 * @property int|null $city_id id города
 * @property string|null $city_title название города
 * @property float|null $salary желаемая зарплата
 * @property int|null $currency_id валюта зарплаты
 * @property int|null $ready_move готов к переезду
 * @property int $notify_email отправлять ли уведомления о подходящих вакансиях по почте
 * @property int $notify_vk отправлять ли уведомления о подходящих вакансиях во ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Currency $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\EmploymentForm[] $employmentForms
 * @property-read \App\Model\Position|null $position
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereCityTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereNotifyEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereNotifyVk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereReadyMove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\JobPreferences whereUserId($value)
 * @mixin \Eloquent
 */
class JobPreferences extends Model {

  protected $_table_name = 'user_job_preferences';

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function currency() {
    return $this->belongsTo('App\Model\Currency');
  }

  public function employmentForms() {
    return $this->belongsToMany('App\Model\EmploymentForm', 'job_preferences_employment_forms');
  }

  //public function save(Validation $validation = null) { //todo event
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

  public function positionTitle() {
    if (!$this->exists) return null;
    return $this->position ? $this->position->title : $this->position_title;
  }

  /**
   * проверка, готов ли пользователь к удаленной работе
   * вернет true, если среди указанных типов занятости будет remote (удаленная работа)
   * @return bool
   */
  public function readyRemote() {
    $containsRemote = $this->employmentForms->contains(function ($employmentForm) {
      /** @var EmploymentForm $employmentForm */
      return $employmentForm->alias == EmploymentForm::REMOTE;
    });

    return $containsRemote;
  }

}