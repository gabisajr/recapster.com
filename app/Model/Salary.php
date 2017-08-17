<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Salary - Зарплата
 *
 * @property int $id
 * @property int $base_pay основная сумма
 * @property string|null $currency_code валюта зарплаты
 * @property int $company_id компания
 * @property string|null $employee_status статус работника: active - действующий, former - бывший
 * @property int|null $last_year последний год работы для бывшего работника
 * @property string $status
 * @property int|null $position_id должность респондента
 * @property string|null $position_title должность респондента - строкой
 * @property int|null $user_id пользователь оставивший данные о зарплате
 * @property string|null $period
 * @property int|null $stage_id стаж работы
 * @property int|null $city_id местоположение офиса
 * @property string|null $city_title местоположение офиса - строкой
 * @property string|null $employment_form_alias форма занятости
 * @property int|null $has_additional_payments есть ли дополнительные выплаты: 1 - да, 0 - нет, null - не указал
 * @property int|null $company_industry_id направление деятельности компании
 * @property int|null $company_size_id размер компании
 * @property int|null $hidden_employer флаг скрытый работодатель
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Company $company
 * @property-read \App\Model\Industry|null $companyIndustry
 * @property-read \App\Model\CompanySize|null $companySize
 * @property-read \App\Model\Currency|null $currency
 * @property-read \App\Model\EmploymentForm|null $employmentForm
 * @property-read \App\Model\Position|null $position
 * @property-read \App\Model\Stage|null $stage
 * @property-read \App\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary status($status)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereBasePay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCityTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCompanyIndustryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCompanySizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereEmployeeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereEmploymentFormAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereHasAdditionalPayments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereHiddenEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereLastYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Salary whereUserId($value)
 * @mixin \Eloquent
 */
class Salary extends Model {

  use Approvable;

  public function company() {
    return $this->belongsTo('App\Model\Company');
  }

  public function currency() {
    return $this->belongsTo('App\Model\Currency', 'currency_code');
  }

  public function employmentForm() {
    return $this->belongsTo('App\Model\EmploymentForm', 'employment_form_alias');
  }

  public function stage() {
    return $this->belongsTo('App\Model\Stage');
  }

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function companyIndustry() {
    return $this->belongsTo('App\Model\Industry');
  }

  public function companySize() {
    return $this->belongsTo('App\Model\CompanySize');
  }

  //todo relation
  protected $_has_many = [
    'additional_payments' => [
      'model'       => 'AdditionalPayment',
      'foreign_key' => 'salary_id',
    ],
  ];

  /**
   * /kazcom/salary/web-developer
   * /salary/web-developer
   *
   * @param bool $full - Включить ли хост в url
   * @return string
   */
  public function get_url($full = true) {
    $url = "";
    if ($full) $url .= "http://$_SERVER[HTTP_HOST]";

    if ($this->company->loaded()) $url .= "/@{$this->company->alias}";

    $url .= "/salaries/";

    $url .= $this->position->alias ? $this->position->alias : $this->position->title;

    return $url;
  }

  public function save_salary(Model_User $user, Array $data = []) {

    /** @var Model_Salary $salary */
    $salary = ORM::factory('Salary', Arr::get($data, 'id'));
    $is_new_salary = !$salary->loaded();

    $salary->hidden_employer = Arr::get($data, 'hidden_employer');
    $salary->company = !$salary->hidden_employer ? ORM::factory('Company', Arr::get($data, 'company_id')) : null;

    $salary->base_pay = Arr::get($data, 'base_pay');
    $salary->currency = ORM::factory('Currency', Arr::get($data, 'currency_code'));
    $salary->period = Arr::get($data, 'payment_period');
    $salary->has_additional_payments = Arr::get($data, 'has_additional_payments');
    $salary->stage = ORM::factory('Stage', Arr::get($data, 'stage_id'));
    $salary->employment = ORM::factory('Employment', Arr::get($data, 'employment_alias'));
    $salary->industry = ORM::factory('Industry', Arr::get($data, 'industry_id'));
    $salary->company_size = ORM::factory('Company_Size', Arr::get($data, 'company_size_id'));
    $salary->user = $user;
    $salary->status = Status::PENDING;

    //местоположение офиса
    $city_title = Arr::get($data, 'city_title');
    /** @var Model_City $city */
    $city = ORM::factory('City')->where('title', 'LIKE', $city_title)->limit(1)->find();
    if ($city->loaded()) {
      $salary->city = $city;
      $salary->city_title = null;
    } else {
      $salary->city = null;
      $salary->city_title = $city_title;
    }

    //должность-профессия
    $position_title = Arr::get($data, 'position_title');
    /** @var Model_Position $position */
    $position = ORM::factory('Position')->where('title', 'LIKE', $position_title)->limit(1)->find();
    if ($position->loaded()) {
      $salary->position = $position;
      $salary->position_title = null;
    } else {
      $salary->position = null;
      $salary->position_title = $position_title;
    }

    //если у нас указана конкретная компания - то для нее нужно еще знать активный/бывший ли работник и последний год работы
    if ($salary->company->loaded()) {
      $salary->active_employee = Arr::get($data, 'active_employee', Bit::YES);
      $salary->last_year = Arr::get($data, 'last_year');
    }

    //если нет должности как сущности - тогда используем просто строку
    if (!$salary->position->loaded()) {
      $salary->position_title = Arr::get($data, 'position_title');
    }

    $salary->save();
    $salary->set_additional_payments(Arr::get($data, 'additional_payments', []));


    if ($is_new_salary) {

      //notify admin about new salary
      $app_name = Kohana::$config->load('app')->get('app_name');
      $subject = __('Новая зарплата на :app_name', [':app_name' => $app_name]);
      $email_html = View::factory('email/notify-salary', ['salary' => $salary, 'app_name' => $app_name])->render();
      Email::instance()->send_admin($subject, $email_html);

    } else {

      //todo notify admin about update salary

    }


    return $salary;

  }

  public function set_additional_payments($payments) {

    //добавить дополнительные выполаты
    if ($this->has_additional_payments == Bit::YES) {

      /** @var Model_AdditionalPayment_Type[] $payments_types */
      $payments_types = ORM::factory('AdditionalPayment_Type')->order_by('sort')->find_all();

      foreach ($payments_types as $type) {

        $data = Arr::get($payments, $type->id, []);
        $value = Arr::get($data, 'value'); //размер выплаты
        $period = Arr::get($data, 'period', Period::YEAR); //период выплаты

        if ($value) {

          /** @var Model_AdditionalPayment $payment */
          $payment = ORM::factory('AdditionalPayment')->where('salary_id', '=', $this->id)->and_where('type_id', '=', $type->id)->find();

          if (!$payment->loaded()) {
            $payment = ORM::factory('AdditionalPayment');
            $payment->salary_id = $this->id;
            $payment->type_id = $type->id;
          }

          $payment->value = $value;
          $payment->period = $period;
          $payment->save();

        } else {

          //delete if exists
          if ($this->loaded()) {
            $payment = ORM::factory('AdditionalPayment')->where('salary_id', '=', $this->id)->and_where('type_id', '=', $type->id)->limit(1)->find();
            if ($payment->loaded()) $payment->delete();
          }

        }

      }

    } else {

      //удалить дополнительные выплаты
      if ($this->loaded()) {
        /** @var Model_AdditionalPayment $additional_payment */
        foreach ($this->additional_payments->find_all() as $additional_payment) {
          $additional_payment->delete();
        }
      }

    }
  }

  public function can_edit() {

    //если не авторизован - тогда нельзя
    if (!Auth::instance()->logged_in()) return false;

    //если админ или суперадмин - то можно
    if (Auth::instance()->logged_in('admin') || Auth::instance()->logged_in('super_admin')) return true;

    //если не являюсь владельцем отзыва - тогда нельзя
    if (Auth::instance()->get_user()->id != $this->user->id) return false;

    //если старее 30 дней тогда нельзя
    if ($this->days_ago() > 30) return false;

    return true;

  }

  public function days_ago() {
    $now = time();
    $added_date = strtotime($this->added);
    $datediff = $now - $added_date;
    return floor($datediff / (60 * 60 * 24));
  }

  public function admin_url() { //todo camel case
    if (!$this->loaded()) return "#";
    return "http://$_SERVER[HTTP_HOST]/admin/salary/item/$this->id"; //todo route
  }

}