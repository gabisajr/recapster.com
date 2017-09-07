<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Faculty
 *
 * @property int $id
 * @property string $title
 * @property int|null $university_id
 * @property int|null $vk_id id факультета ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Chair[] $chairs
 * @property-read \App\Model\University|null $university
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty ofUniversity($university)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Faculty whereVkId($value)
 * @mixin \Eloquent
 */
class Faculty extends Model {

  public function university() {
    return $this->belongsTo('App\Model\University');
  }

  public function chairs() {
    return $this->hasMany('App\Model\Chair', 'faculty_id');
  }

  /**
   * Scope a query to only faculties of $university
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param int|University $university
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfUniversity($query, $university) {
    $universityId = null;
    if ($university instanceof University) {
      $universityId = $university->id;
    } elseif (is_numeric($university)) {
      $universityId = $university;
    } else {
      error_log("invalid university argument: value '$university', needs University or int");
    }

    if ($universityId) {
      $query->where('faculties.university_id', '=', $universityId);
    }

    return $query;
  }

  //todo validation
  //public function rules() {
  //  return [
  //    'university_id' => [
  //      ['not_empty'],
  //    ],
  //    'title'         => [
  //      ['not_empty'],
  //      //todo unique title in one university
  //    ],
  //  ];
  //}

  ////todo observer
  //public function delete() {
  //
  //  //удалить квафедры
  //  foreach ($this->chairs->find_all() as $chair) $chair->delete();
  //
  //  return parent::delete();
  //}

}