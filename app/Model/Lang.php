<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Lang - Язык
 * @property int    $id
 * @property string $title
 */
class Lang extends Model {

  public function users() {
    return $this->belongsToMany('App\Model\User', 'users_langs');
  }

  public function rules() {
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
    ];
  }

}