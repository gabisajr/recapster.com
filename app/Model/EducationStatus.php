<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\EducationStatus
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationStatus whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EducationStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EducationStatus extends Model {

  //public function rules() { //todo validation
  //  return [
  //    'title' => [
  //      ['not_empty'],
  //      [[$this, 'unique'], ['title', ':value']],
  //    ],
  //  ];
  //}

}