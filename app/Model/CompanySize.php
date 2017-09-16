<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\CompanySize - размер компании, кол-во сотрудников
 *
 * @property int $id
 * @property string $slug
 * @property string|null $employees_count
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanySize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanySize whereEmployeesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanySize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanySize whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanySize whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CompanySize whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanySize extends Model {

  const SMALL = 'SMALL';
  const SMALL_TO_MEDIUM = 'SMALL_TO_MEDIUM';
  const MEDIUM = 'MEDIUM';
  const MEDIUM_TO_LARGE = 'MEDIUM_TO_LARGE';
  const LARGE = 'LARGE';
  const LARGE_TO_GIANT = 'LARGE_TO_GIANT';
  const GIANT = 'GIANT';
  const UNKNOWN = 'UNKNOWN';

  //todo relation
  protected $_has_many = [
    'companies' => [
      'model'       => 'Company',
      'foreign_key' => 'size_id',
    ],
  ];

  //public function get($column) {
  //
  //  switch ($column) {
  //    case 'title': //todo add title() method
  //      return __(':count :employees', [':count' => $this->employees_count, ':employees' => __('работников')]);
  //      break;
  //  }
  //
  //  return parent::get($column);
  //}
  //
  //public static function exists($id) {
  //  return ORM::factory('Company_Size', $id)->loaded();
  //}

}