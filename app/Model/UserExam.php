<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Exam - Тест, экзамен или курс проейденный пользователем
 * @property int        $id
 * @property string     $title          - название
 * @property string     $organization   - организация
 * @property string     $specialization - специализация
 * @property int        $year           - год
 *
 * --------------- belongs to --------------
 * @property Model_User $user
 * @property int        $user_id
 */
class UserExam extends Model {

  function user(){
    return $this->belongsTo('App\Model\User');
  }

  public function rules() { //todo validation
    return [
      'title'          => [
        ['not_empty'],
      ],
      'organization'   => [
        ['not_empty'],
      ],
      'specialization' => [
        ['not_empty'],
      ],
      'year'           => [
        ['not_empty'],

        //проверяем чтобы год не уходил в будущее
        [function ($year, Validation $validation, $field) {
          $curr_year = (int)date('Y');
          if ($year && ($year > $curr_year)) {
            $validation->error($field, 'in_future');
          }
        }, [':value', ':validation', ':field']],

      ],
      'user_id'        => [
        ['not_empty'],
      ],
    ];
  }

}