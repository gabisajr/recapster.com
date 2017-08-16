<?php

namespace App\Model;

use App\Notifications\PasswordResetNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
use Auth;

/**
 * Class User
 * @package App\Model
 * @property int    $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $username
 * @property string $password (hashed)
 * @property int    $avatar_id
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Authenticatable {

  use Notifiable;

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
   * @param  string                               $search
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
    return url("/$this->username/$section");
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
    return null;
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

}