<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Skill - Навык
 * @property int    $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 */
class Skill extends Model {

  public function users() {
    return $this->belongsToMany('App\Model\User', 'users_skills');
  }

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
    ];
  }

}