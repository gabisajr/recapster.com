<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Chair
 *
 * @property int $id
 * @property string $title
 * @property int|null $faculty_id
 * @property int|null $vk_id id кафедры ВКонтакте
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Faculty|null $faculty
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair ofFaculty($faculty)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Chair whereVkId($value)
 * @mixin \Eloquent
 */
class Chair extends Model {

  public function faculty() {
    return $this->belongsTo('App\Model\Faculty');
  }

  public function scopeOfFaculty($query, $faculty) {
    $facultyId = null;
    if ($faculty instanceof Faculty) {
      $facultyId = $faculty->id;
    } elseif (is_numeric($faculty)) {
      $facultyId = $faculty;
    } else {
      error_log("invalid faculty argument: value '$faculty', needs Faculty or int");
    }

    if ($facultyId) {
      $query->where('chairs.faculty_id', '=', $facultyId);
    }

    return $query;
  }

}