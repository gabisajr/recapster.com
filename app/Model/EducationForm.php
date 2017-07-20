<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EducationForm - форма обучения
 * @property int    $id
 * @property string $title - название
 * @property string $vk_education_form
 * @property int    $sort
 * @property string $created_at
 * @property string $updated_at
 */
class EducationForm extends Model {

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
    ];
  }

}