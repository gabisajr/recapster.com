<?php

namespace App\Model;

use App\Notifications\PasswordResetNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Model
 * @property int    $id
 * @property string $name
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
    if ($this->name || $this->lastname) {
      $parts = [];
      if ($this->name) $parts[] = $this->name;
      if ($this->lastname) $parts[] = $this->lastname;
      return implode(' ', $parts);
    }
    return null;
  }

}
