<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Company доход компании
 *
 * @property int             id
 * @property string          title
 * @property Model_Company[] companies
 */
class CompanyRevenue extends Model {

  //todo relation
  protected $_has_many = [
    'companies' => [
      'model'       => 'Company',
      'foreign_key' => 'revenue_id',
    ],
  ];

}