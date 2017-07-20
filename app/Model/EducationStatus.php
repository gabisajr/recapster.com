<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Education_Status - статус обучения (специалист, бакалавр, магистр...)
 * @property int    $id
 * @property string $title - название
 * @property int    $sort
 * @property string $created_at
 * @property string $updated_at
 */
class EducationStatus extends Model {

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
    ];
  }

}