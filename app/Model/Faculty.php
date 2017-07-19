<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Faculty
 * @property int              $id
 * @property string           $title
 * @property int              $vk_id
 *
 * ----------------- belongs to: ----------------------
 * @property Model_University $university - университет
 * @property int              $university_id
 *
 * ----------------- has many ------------------------
 * @property ORM              $chairs     - кафедры/направления факультета
 */
class Faculty extends Model {

  public function university() {
    return $this->belongsTo('App\Model\University');
  }

  //todo relation
  protected $_has_many = [
    'chairs' => [
      'model'       => 'Chair',
      'foreign_key' => 'faculty_id',
    ],
  ];

  ////todo validation
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