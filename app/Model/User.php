<?php

namespace App\Model;

use App\Notifications\PasswordResetNotification;
use App\Recommend;
use App\UserJobStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
use Auth;

/**
 * App\Model\User
 *
 * @property int $id
 * @property string $firstname
 * @property string|null $lastname
 * @property string $email
 * @property string|null $username
 * @property string $password
 * @property int $sex пол
 * @property int|null $position_id должность или профессия пользователя
 * @property string|null $position_title должность или профессия пользователя (без привязки)
 * @property int|null $country_id id страны
 * @property int|null $city_id id города
 * @property string|null $job_status статус - готовность к работе
 * @property int|null $birth_day
 * @property int|null $birth_month
 * @property string|null $birth_year
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Image $avatar
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\UserEducation[] $educations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\UserExam[] $exams
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\UserExperience[] $experiences
 * @property-read \App\Model\JobPreferences $jobPreferences
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Lang[] $langs
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Model\Position|null $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Skill[] $skills
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Subscription[] $subscribers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Subscription[] $subscriptions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereBirthDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereBirthMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereBirthYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereJobStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable {

  use Notifiable, Positionable;

  public function avatar() {
    return $this->belongsTo('App\Model\Image');
  }

  public function experiences() {
    return $this->hasMany('App\Model\UserExperience', 'user_id');
  }

  public function educations() {
    return $this->hasMany('App\Model\UserEducation', 'user_id');
  }

  public function exams() {
    return $this->hasMany('App\Model\UserExam', 'user_id');
  }

  public function skills() {
    return $this->belongsToMany('App\Model\Skill', 'users_skills');
  }

  public function langs() {
    return $this->belongsToMany('App\Model\Lang', 'users_langs');
  }

  public function subscriptions() {
    return $this->morphMany('App\Model\Subscription', 'object');
  }

  public function subscribers() {
    return $this->morphMany('App\Model\Subscription', 'subscriptions');
  }

  public function country() {
    return $this->belongsTo('App\Model\Country');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function jobPreferences() {
    return $this->hasOne('App\Model\JobPreferences');
  }

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * Scope a query to search users by string
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param  string $search
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearch($query, $search) {

    if (is_numeric($search)) {
      $query->where('id', '=', $search);
    }

    //todo create tables and another scopes for search by socials accounts
    //->join('facebook_accounts', 'LEFT')->on('user.fb_user_id', '=', 'facebook_accounts.fb_user_id')
    //->join('vk_accounts', 'LEFT')->on('user.vk_user_id', '=', 'vk_accounts.vk_user_id')

    $query->orWhere(function ($query) use ($search) {

      $query
        //по имени
        ->orWhere('firstname', 'LIKE', "%$search%")
        //по фамилии
        ->orWhere('lastname', 'LIKE', "%$search%")
        //по логину
        ->orWhere('username', 'LIKE', "%$search%")
        //по email-у
        ->orWhere('email', 'LIKE', "%$search%")

        //по имени-фамилии facebook
        //->orWhere('facebook_accounts.firstname', 'LIKE', "%$search%")->orWhere('facebook_accounts.lastname', 'LIKE', "%$search%")

        //по имени-фамилии vk
        //->orWhere('vk_accounts.firstname', 'LIKE', "%$search%")->orWhere('vk_accounts.lastname', 'LIKE', "%$search%")
      ;

    });

    return $query;
  }

  public function url($section = null) {
    return url("/user/$this->username/$section");
  }


  /**
   * Send the password reset notification.
   *
   * @param  string $token
   * @return void
   */
  public function sendPasswordResetNotification($token) {
    $notification = new PasswordResetNotification($token);
    $this->notify($notification);
  }

  public function fullname() {
    if ($this->firstname || $this->lastname) {
      $parts = [];
      if ($this->firstname) $parts[] = $this->firstname;
      if ($this->lastname) $parts[] = $this->lastname;
      return implode(' ', $parts);
    }
    return "@" . $this->username;
  }

  public function age() {
    //todo create db fields
    $birthYear = (int)$this->birth_year;
    $birthDay = (int)$this->birth_day;
    $birthMonth = (int)$this->birth_month;

    if (!$birthYear) return null;

    if (!$birthDay) $birthDay = 1;
    if (!$birthMonth) $birthMonth = 1;

    $date = "{$birthYear}-{$birthMonth}-{$birthDay}";
    return DateTime::createFromFormat('Y-m-d', $date)->diff(new DateTime('now'))->y;
  }

  /** @return boolean - returns true if the user instance is current auth user */
  public function isMe() {
    $currUser = Auth::getUser();
    return $currUser && $currUser->id == $this->id;
  }

  public function jobStatusTitle() {
    $status = $this->status ? $this->job_status : UserJobStatus::NOT_SEARCH;
    return array_get(UserJobStatus::getStatuses(), $status);
  }

  public function recommendJobs($limit, array $exceptIds = []) {
    return recommend_jobs($this, $limit, $exceptIds);
  }

  /**
   * @param User|Company $object
   * @return bool
   */
  public function subscribedOn($object) {

    if ($object instanceof Company) {
      return (bool)$this->subscriptions()->where('object_type', '=', 'company')->where('object_id', '=', $object->id)->count();
    } elseif ($object instanceof User) {
      return (bool)$this->subscriptions()->where('object_type', '=', 'user')->where('object_id', '=', $object->id)->count();
    }

    return false;
  }

}