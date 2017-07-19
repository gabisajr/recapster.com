<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanySize размер компании, кол-во сотрудников
 *
 * @property int             id
 * @property string          alias
 * @property string          employees_count - количество работников: '100-200'
 * @property string          title           - вернет 100-200 работников (virtual)
 * @property int             sort
 * @property Model_Company[] companies
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