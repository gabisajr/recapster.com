<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Subscription - Подписка пользователя
 *
 * @property int $id
 * @property int $user_id     id пользователя
 * @property int $object_id   id объекта подписки
 * @property int $object_type тип объекта подписки
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $object
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscription whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscription whereObjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscription whereUserId($value)
 * @mixin \Eloquent
 */
class Subscription extends Model {

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function object() {
    return $this->morphTo();
  }

}