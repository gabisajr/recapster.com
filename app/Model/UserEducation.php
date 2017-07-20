<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Education
 * @property int                    $id
 * @property int                    $start_year  - год начала обучения
 * @property int                    $start_month - месяц начала обучения
 * @property string                 $specialty   - специальность
 * @property int                    $end_year    - год окончания обучения
 * @property int                    $end_month   - месяц окончания обучения
 * @property int                    $text        - описание (специализация и достижения)
 *
 * ---------------- belongs to: --------------
 * @property Model_University       $university
 * @property int                    $university_id
 *
 * @property Model_Faculty          $faculty
 * @property int                    $faculty_id
 *
 * @property Model_Chair            $chair
 * @property int                    $chair_id
 *
 * @property Model_Education_Form   $edu_form
 * @property int                    $edu_form_id
 *
 * @property Model_User             $user
 * @property int                    $user_id
 *
 * @property Model_Education_Status $status
 * @property int                    $status_id
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