<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\EducationForm
 *
 * @property int $id
 * @property string $title название формы обучения
 * @property string $vk_education_form форма обучения ВКонтакте
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationForm whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationForm whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationForm whereVkEducationForm($value)
 * @mixin \Eloquent
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