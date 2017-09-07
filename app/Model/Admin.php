<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;

/**
 * App\Model\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property int $is_super_admin
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereIsSuperAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable {

  use Notifiable;

  protected $guard = 'admin';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'job_title',
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
   * Send the password reset notification.
   *
   * @param  string $token
   * @return void
   */
  public function sendPasswordResetNotification($token) {
    $notification = new PasswordResetNotification($token);
    $this->notify($notification);
  }

}
