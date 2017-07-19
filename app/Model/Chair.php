<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Faculty - кафедра
 * @property int           $id
 * @property string        $title
 * @property int           $vk_id
 *
 * ------------------ belongs to ---------------
 * @property Model_Faculty $faculty
 * @property int           $faculty_id
 */
class Chair extends Model {

  public function faculty() {
    return $this->belongsTo('App\Model\Faculty');
  }

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
      ],
      'vk_id' => [
        [[$this, 'unique'], ['vk_id', ':value']],
      ],
    ];
  }

}