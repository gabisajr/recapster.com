<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stage стаж работы
 * @property int    $id
 * @property string $title
 * @property int    $sort
 * @property string $created_at
 * @property string $updated_at
 */
class Stage extends Model {

  //todo relation
  protected $_has_many = [
    'reviews' => [
      'model'       => 'Review',
      'foreign_key' => 'stage_id',
    ],
  ];

  //public static function exists($id) {
  //  return ORM::factory('Stage', $id)->loaded();
  //}

}