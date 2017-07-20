<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Position - Должность
 *
 * @property int    id
 * @property string title            - название должности
 * @property string alias            - альяс для ссылки
 * @property int    salaries_count   - кол-во одобренных зарплат
 * @property int    reviews_count    - кол-во одобренных отзывов
 * @property int    interviews_count - кол-во одобренных собеседований
 * @property int    jobs_count       - кол-во активных вакансий
 *
 * ------------------- virtual -----------------------------
 * @property string $of_position     - родительный падеж название должности
 *
 * ------------------- has many ----------------------------
 * @property ORM    salaries         - зарплаты
 * @property ORM    reviews          - отзывы
 * @property ORM    interviews       - собеседования
 * @property ORM    jobs             - вакансии
 */
class Position extends Model {

  //todo relation
  protected $_has_many = [
    'salaries'   => [
      'model'       => 'Salary',
      'foreign_key' => 'position_id',
    ],
    'reviews'    => [
      'model'       => 'Review',
      'foreign_key' => 'position_id',
    ],
    'interviews' => [
      'model'       => 'Interview',
      'foreign_key' => 'position_id',
    ],
    'jobs'       => [
      'model'       => 'Job',
      'foreign_key' => 'position_id',
    ],
  ];

  public function rules() { //todo validation
    return [
      'title' => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
      'alias' => [
        ['not_empty'],
        [[$this, 'unique'], ['alias', ':value']],
      ],
    ];
  }

  //public function get($column) {
  //  switch ($column) {
  //    case 'of_position':
  //      return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'Р') : $this->title;
  //      break;
  //  }
  //  return parent::get($column);
  //}

  public function filters() {
    return [
      'title' => [
        ['trim'],
      ],
      'alias' => [
        ['trim'],
        ['mb_strtolower'],
      ],
    ];
  }

  public function recount_all() {
    $this->reviews_count = $this->reviews->where('status', '=', Status::APPROVED)->count_all();
    $this->salaries_count = $this->salaries->where('status', '=', Status::APPROVED)->count_all();
    $this->interviews_count = $this->interviews->where('status', '=', Status::APPROVED)->count_all();
    $this->jobs_count = $this->jobs->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во одобренных отзывов
   *
   * @return Model_Company
   */
  public function recount_reviews() {
    $this->reviews_count = $this->reviews->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во одобренных зарплат
   *
   * @return Model_Company
   */
  public function recount_salaries() {
    $this->salaries_count = $this->salaries->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во одобренных собеседований
   *
   * @return Model_Company
   */
  public function recount_interviews() {
    $this->interviews_count = $this->interviews->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  /**
   * пересчитать и сохранить кол-во одобренных вакансий
   *
   * @return Model_Company
   */
  public function recount_jobs() {
    $this->jobs_count = $this->jobs->where('status', '=', Status::APPROVED)->count_all();
    return $this->save();
  }

  public static function route_filter_alias($route, $params, $request) {

    $alias = Arr::get($params, 'position_alias');
    $position = ORM::factory('Position', ['alias' => $alias]);
    $request->position = $position;

    if (!empty($alias)) return $position->loaded();

    return null;
  }

}