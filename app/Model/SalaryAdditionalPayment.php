<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_AdditionalPayment - Дополнительная выплата к зарплате
 *
 * @property int                          id
 *
 * @property Model_Salary                 salary - зарплата к которой относится эта дополнительная выплата
 * @property int                          salary_id
 *
 * @property Model_AdditionalPayment_Type type   - тип дополнительной выплаты
 * @property int                          type_id
 *
 * @property int                          value  - сумма допвыплаты
 * @property string                       period - период выплаты @see modules/enums/classes/Period.php
 */
class SalaryAdditionalPayment extends Model {

  public function salary() {
    return $this->belongsTo('App\Model\Salary');
  }

  public function type() {
    return $this->belongsTo('App\Model\SalaryAdditionalPaymentType');
  }

}