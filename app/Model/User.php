<?php

namespace App\Model;

use App\Notifications\PasswordResetNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;

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
    return $query->where('user.id', '=', $search)

      //todo create tables and another scopes for search by socials accounts
      //->join('facebook_accounts', 'LEFT')->on('user.fb_user_id', '=', 'facebook_accounts.fb_user_id')
      //->join('vk_accounts', 'LEFT')->on('user.vk_user_id', '=', 'vk_accounts.vk_user_id')

      ->orWhere(function ($query) use ($search) {

        $query
          //по имени
          ->orWhere('user.firstname', 'LIKE', "%$search%")
          //по фамилии
          ->orWhere('user.lastname', 'LIKE', "%$search%")
          //по логину
          ->orWhere('user.username', 'LIKE', "%$search%")
          //по email-у
          ->or_where('user.email', 'LIKE', "%$search%")

          //по имени-фамилии facebook
          //->or_where('facebook_accounts.firstname', 'LIKE', "%$search%")->or_where('facebook_accounts.lastname', 'LIKE', "%$search%")

          //по имени-фамилии vk
          //->or_where('vk_accounts.firstname', 'LIKE', "%$search%")->or_where('vk_accounts.lastname', 'LIKE', "%$search%")
        ;

      });
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

}