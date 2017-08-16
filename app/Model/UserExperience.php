<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Experience - Опыт работы
 * @property int            $id
 * @property boolean        $is_internship  - является ли стажировкой
 * @property int            $start_month    - начало работы, месяц
 * @property int            $start_year     - начало работы, год
 * @property int            $end_month      - окончание работы, месяц
 * @property int            $end_year       - окончание работы, год
 * @property boolean        $is_current     - работает по настоящее время
 * @property string         $text           - обязанности и достижения
 *
 * ------------------- belongs to: ---------------------------------------
 * @property Model_Position $position       - должность
 * @property int            $position_id
 * @property string         $position_title - название должности (без привязки)
 *
 * @property Model_Company  $company        - компания
 * @property int            $company_id
 * @property string         $company_title  - название компании (без привязки)
 *
 * @property Model_City     $city
 * @property int            $city_id
 * @property string         $city_title     - название города (без привязки)
 *
 * @property Model_User     $user           - пользователь
 * @property int            $user_id
 *
 */
class UserExperience extends Model {

  //todo relations
  protected $_belongs_to = [
    'position' => [
      'model'       => 'Position',
      'foreign_key' => 'position_id',
    ],
    'company'  => [
      'model'       => 'Company',
      'foreign_key' => 'company_id',
    ],
    'city'     => [
      'model'       => 'City',
      'foreign_key' => 'city_id',
    ],
    'user'     => [
      'model'       => 'User',
      'foreign_key' => 'user_id',
    ],
  ];

  public function filters() {
    return [
      true => [
        ['trim'],
        ['strip_tags'],
        [function ($value) {
          return (!$value) ? null : $value;
        }],
      ],
    ];
  }

  public function rules() {
    return [
      'company_title' => [
        [[$this, 'need_company_title'], [':value', ':validation', ':field']],
      ],
      'start_month'   => [
        ['not_future_month', [$this->start_year, ':value']],
      ],
      'start_year'    => [
        ['not_future_year'],
      ],
      'end_month'     => [
        ['not_future_month', [$this->end_year, ':value']],

        //проверяем чтобы месяц окончания был не меньше месяца начала работы
        [function ($end_month, Validation $validation, $field) {
          if ($this->start_year && $this->end_year && ($this->start_year == $this->end_year) && $this->start_month && $end_month && ($end_month < $this->start_month)) {
            $validation->error($field, 'invalid');
          }
        }, [':value', ':validation', ':field']],

      ],
      'end_year'      => [
        ['not_future_year'],

        //проверяем чтобы год окончания работы не превышал год начала работы
        [function ($end_year, Validation $validation, $field) {
          if ($end_year && ($end_year < $this->start_year)) {
            $validation->error($field, 'invalid');
          }
        }, [':value', ':validation', ':field']],

      ],
    ];
  }

  public function need_end($end_value, Validation $validation, $field) {
    if (!$this->is_current && !$end_value) {
      $validation->error($field, 'not_empty');
    }
  }

  public function need_company_title($company_title, Validation $validation, $field) {
    if (!$this->company->loaded() && !$company_title) {
      $validation->error($field, 'not_empty');
    }
  }

  //public function save(Validation $validation = null) {
  //
  //  if ($this->is_current) {
  //    $this->end_month = null;
  //    $this->end_year = null;
  //  }
  //
  //  if ($this->company_title && (!$this->company->loaded() || ($this->company->title != $this->company_title))) {
  //    $company = ORM::factory('Company')->where('company.title', 'LIKE', $this->company_title)->find();
  //    $this->company = $company;
  //  }
  //
  //  if ($this->position_title && (!$this->position->loaded() || ($this->position->title != $this->position_title))) {
  //    $position = ORM::factory('Position')->where('position.title', 'LIKE', $this->position_title)->find();
  //    $this->position = $position;
  //  }
  //
  //  if ($this->city_title && (!$this->city->loaded() || ($this->city->title != $this->city_title))) {
  //    $city = ORM::factory('City')->where('city.title', 'LIKE', $this->city_title)->find();
  //    $this->city = $city;
  //  }
  //
  //  return parent::save($validation);
  //}

  /** @return Model_Review */
  public function get_review() {

    /** @var Model_User $curr_user */
    $curr_user = Auth::instance()->get_user();

    $query = ORM::factory('Review')
      ->where('review.company_id', '=', $this->company->id)
      ->and_where('review.user_id', '=', $this->user->id)
      ->order_by('review.added', 'DESC');

    if (!$curr_user || ($curr_user->id != $this->user->id)) {
      $query->and_where('review.status', '=', Status::APPROVED);
    }

    $review = $query->find();

    return $review;
  }

}