<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserEducation
 *
 * @property int $id
 * @property int $user_id пользователь
 * @property int|null $university_id университет
 * @property int|null $faculty_id факультет
 * @property int|null $chair_id кафедра/направление
 * @property int|null $edu_form_id
 * @property int|null $start_year год начала обучения
 * @property int|null $start_month месяц начала обучения
 * @property int|null $end_year год окончания обучения
 * @property int|null $end_month месяц окончания обучения
 * @property string $text описание (специализация и достижения)
 * @property string|null $specialty специальность
 * @property int|null $status_id статус образования
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Chair|null $chair
 * @property-read \App\Model\EducationForm|null $educationForm
 * @property-read \App\Model\EducationStatus|null $educationStatus
 * @property-read \App\Model\Faculty|null $faculty
 * @property-read \App\Model\University|null $university
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereChairId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereEduFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereEndMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereEndYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereSpecialty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereStartMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereUniversityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserEducation whereUserId($value)
 * @mixin \Eloquent
 */
class UserEducation extends Model {

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function university() {
    return $this->belongsTo('App\Model\University');
  }

  public function faculty() {
    return $this->belongsTo('App\Model\Faculty');
  }

  public function chair() {
    return $this->belongsTo('App\Model\Chair');
  }

  public function educationForm() {
    return $this->belongsTo('App\Model\EducationForm', 'edu_form_id');
  }

  public function educationStatus(){
    return $this->belongsTo('App\Model\EducationStatus', 'status_id');
  }

  public function rules() { //todo validation
    return [
      'university_id' => [
        ['not_empty'],
      ],
    ];
  }

}