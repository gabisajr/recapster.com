<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Виды дополнительных выплат
 * Class Model_AdditionalPayment
 *
 * @property int                       id
 * @property string                    title
 * @property string                    periods
 * @property Model_AdditionalPayment[] additional_payments - все допплатежи данного типа
 */
class SalaryAdditionalPaymentType extends Model {


  //todo relation
  protected $_has_many = [
    'additional_payments' => [
      'model'       => 'AdditionalPayment',
      'foreign_key' => 'type_id',
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

  public function get_available_periods() {
    $arr = preg_split('/[\s,]+/', $this->periods);
    $arr_new = [];

    foreach ($arr as $_period) {

      $period = mb_strtolower($_period);

      $arr_new[] = [
        'code'    => $period,
        'caption' => Period::per($period),
      ];
    }

    return $arr_new;
  }

}