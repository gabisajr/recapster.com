<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Industry
 *
 * @property int     $id
 * @property string  $title
 * @property boolean $approved
 * @property string  $created_at
 * @property string  $updated_at
 * -------------------- has many ------------------------
 * @property ORM     $companies
 */
class Industry extends Model {

  //todo relation
  protected $_has_many = [
    'companies' => [
      'model'       => 'Company',
      'foreign_key' => 'industry_id',
    ],
  ];

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
    ];
  }

  //public static function exists($id) {
  //  return ORM::factory('Industry', $id)->loaded();
  //}

}