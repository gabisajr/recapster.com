<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Salary - Зарплата
 *
 * @property int                id
 * @property int                base_pay                  - основная сумма
 * @property string             added                     - дата добавления
 * @property string             last_updated              - время последнего обновления
 * @property string             period                    - период оплаты
 * @property int                has_additional_payments   - есть ли дополнительные выплаты: Bit::YES, Bit::NO
 * @property string             status                    - статус зарплаты @see modules/enums/classes/Status.php
 * @property int                active_employee           - действующий работник: Bit::YES, Bit::NO
 * @property int                last_year                 - последний год работы, для бывшего работника
 * @property boolean            hidden_employer           - скрытый работодатель
 *
 * @property string             url                       - ссылка на зарплату (virtual)
 *
 * @property Model_Currency     currency                  - валюта зарпаты
 * @property string             currency_code
 *
 * @property Model_Company      company                   - компания
 * @property int                company_id
 *
 * @property Model_Position     position                  - должность
 * @property int                position_id
 * @property string             position_title            - черновое поле
 *
 * @property Model_User         user                      - пользователь оставивший зарплату
 * @property int                user_id
 *
 * @property Model_User         last_updated_user         - пользователь послений изменивший
 * @property int                last_updated_user_id
 *
 * @property Model_Employment   $employment               - форма занятости
 * @property string             $employment_alias
 *
 * @property Model_Stage        stage                     - стаж работы
 * @property int                stage_id
 *
 * @property Model_City         city                      - место положение офиса
 * @property int                city_id
 * @property string             city_title                - черновое поле
 *
 * @property Model_Industry     industry                  - направление деятельности компании
 * @property int                industry_id
 *
 * @property Model_Company_Size company_size              - размер компании
 * @property int                company_size_id
 *
 * @property ORM                additional_payments       - дополнительные платежи
 *
 */
class Salary extends Model {

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

  //public function create(Validation $validation = null) {
  //  $this->added = date("Y-m-d H:i:s");
  //  return parent::create($validation);
  //}
  //
  //public function update(Validation $validation = null) {
  //  $user = Auth::instance()->get_user();
  //  if ($user) $this->last_updated_user = $user;
  //  return parent::update($validation);
  //}
  //
  //public function delete() {
  //
  //  $salary_position = $this->position;
  //  $salary_company = $this->company;
  //
  //  //при удалении пересчитать количество активных зарплат у професии и компании
  //  $need_recount_salaries_at_position = ($this->status == Status::APPROVED) && $this->position->loaded();
  //  $need_recount_salaries_at_company = ($this->status == Status::APPROVED) && $this->company->loaded();
  //
  //  //remove additional payments
  //  foreach ($this->additional_payments->find_all() as $payment) $payment->delete();
  //
  //  $res = parent::delete();
  //
  //  //recount
  //  if ($need_recount_salaries_at_position) $salary_position->recount_salaries();
  //  if ($need_recount_salaries_at_company) $salary_company->recount_salaries();
  //
  //  return $res;
  //}
  //
  //public function get($column) {
  //  switch ($column) {
  //    case 'url':
  //      return $this->get_url();
  //      break;
  //  }
  //
  //  return parent::get($column);
  //}

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

  public function admin_url() {
    if (!$this->loaded()) return "#";
    return "http://$_SERVER[HTTP_HOST]/admin/salary/item/$this->id";
  }

}