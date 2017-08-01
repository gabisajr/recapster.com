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

  /**
   * Scope a query to only approved industries
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeApproved($query) {
    return $query->where('approved', '=', true);
  }

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