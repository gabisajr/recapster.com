<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Review Отзыв о компании
 *
 * @property int              $id
 * @property boolean          $anonym                    - является ли анонимным
 * @property string           $text                      - текст отзыва
 * @property boolean          $active_employee           - респондент работает к компании
 * @property string           $added                     - дата добавления
 * @property string           $last_updated              - дата последнего изменения
 * @property string           $status                    - статус отзыва @see modules/enums/classes/Status.php
 * @property int              $rating                    - рейтинг
 * @property boolean          $recommend                 - рекомендую друзьям
 *
 * -------------------------------- virtual --------------------------------------------
 * @property string           $url                       - ссылка на отзыв
 * @property Model_Activity   $activity                  - активность отзыва
 *
 * -------------------------------- has many --------------------------------------------
 *
 * @property ORM              $comments                  - комментарии к отзыву (ответы)
 *
 * -------------------------------- belongs to --------------------------------------------
 *
 * @property Model_Employment $employment                - форма занятости
 * @property string           $employment_alias
 *
 * @property Model_City       $city                      - место положение офиса
 * @property int              $city_id
 * @property string           $city_title                - черновое поле
 *
 * @property Model_Stage      $stage                     - стаж работы
 * @property int              $stage_id
 *
 * @property Model_Position   $position                  - должность респондента
 * @property int              $position_id
 * @property string           $position_title            - черновое поле
 *
 * @property Model_User       $user                      - пользователь оставивший отзыв
 * @property int              $user_id
 *
 * @property Model_User       $last_updated_user         - кем были сделаны последние изменения
 * @property int              $last_updated_user_id
 *
 * @property Model_Company    $company                   - компания
 * @property int              $company_id
 */
class Review extends Model {

  public $index = 0;

  public function company() {
    return $this->belongsTo('App\Model\Company');
  }

  public function employmentForm() {
    return $this->belongsTo('App\Model\EmploymentForm', 'employment_form_alias');
  }

  public function stage() {
    return $this->belongsTo('App\Model\Stage');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  //todo morph relation
  protected $_has_many = [
    'comments' => [
      'model'       => 'Review_Comment',
      'foreign_key' => 'for_id',
    ],
  ];

  public function rules() { //todo validation
    return [
      'rating'           => [
        ['not_empty'],
        ['numeric'],
        ['range', [':value', 1, 5]],
      ],
      'text'             => [
        ['not_empty'],
      ],
      'company_id'       => [
        ['not_empty'],
      ],
      'employment_alias' => [
        [function ($employment_alias, Validation $validation, $field) {
          if ($employment_alias) {
            $employment = ORM::factory('Employment', $employment_alias);
            if (!$employment->loaded()) $validation->error($field, 'invalid');
          }
        }, [':value', ':validation', ':field']],
      ],
      'stage_id'         => [
        [function ($stage_id, Validation $validation, $field) {
          if ($stage_id) {
            $stage = ORM::factory('Stage', $stage_id);
            if (!$stage->loaded()) $validation->error($field, 'invalid');
          }
        }, [':value', ':validation', ':field']],
      ],
      'status'           => [
        ['not_empty'],
        ['in_array', [':value', Status::$all]],
      ],
    ];
  }

  //public function create(Validation $validation = null) {
  //  if (!$this->added) $this->added = date("Y-m-d H:i:s");
  //  $this->user = Auth::instance()->get_user();
  //  return parent::create($validation);
  //}
  //
  //public function update(Validation $validation = null) {
  //  $user = Auth::instance()->get_user();
  //  if ($user) $this->last_updated_user = $user;
  //  return parent::update($validation);
  //}
  //
  //public function get($column) {
  //  switch ($column) {
  //    case 'url':
  //      return $this->get_url();
  //      break;
  //    case 'activity':
  //      return $this->get_activity();
  //      break;
  //  }
  //
  //  return parent::get($column);
  //}


  public function get_url() {
    if (!$this->company->active) return '#';
    return "http://$_SERVER[HTTP_HOST]/{$this->company->alias}/review/{$this->id}";
  }

  /** @return Model_Activity */
  public function get_activity() {
    return ORM::factory('Activity', ['review_id' => $this->id]);
  }

  //выдает надпись "Я работал в компании на постояной основе (более года)"
  public function recap_experience() {

    if (!$this->employment->loaded()) return null;

    function work(Model_Review $review) {
      $text = "";

      //действующий работник
      if ($review->active_employee) {
        $text = __('работаю');
      } //бывший работник, не анонимный, пол указан
      elseif (!$review->anonym && in_array($review->user->sex, [Sex::MALE, Sex::FEMALE])) {
        if ($review->user->sex == Sex::MALE) {
          $text = __('работал');
        } elseif ($review->user->sex == Sex::FEMALE) {
          $text = __('работала');
        }
      } //бывший работник, анонимный либо неопределеный пол
      else $text = __('работал(а)');

      return $text;
    }

    function volunteer(Model_Review $review) {
      $text = "";

      //действующий работник
      if ($review->active_employee) {
        $text = __('являюсь волонтером');
      } //бывший работник, не анонимный, пол указан
      elseif (!$review->anonym && in_array($review->user->sex, [Sex::MALE, Sex::FEMALE])) {
        if ($review->user->sex == Sex::MALE) {
          $text = __('был волонтером');
        } elseif ($review->user->sex == Sex::FEMALE) {
          $text = __('была волонтером');
        }
      } //бывший работник, анонимный либо неопределеный пол
      else $text = __('был(а) волонтером');

      return $text;
    }

    function probation(Model_Review $review) {
      $text = "";

      //действующий работник
      if ($review->active_employee) {
        $text = __('стажируюсь');
      } //бывший работник, не анонимный, пол указан
      elseif (!$review->anonym && in_array($review->user->sex, [Sex::MALE, Sex::FEMALE])) {
        if ($review->user->sex == Sex::MALE) {
          $text = __('стажировался');
        } elseif ($review->user->sex == Sex::FEMALE) {
          $text = __('стажировалась');
        }
      } //бывший работник, анонимный либо неопределеный пол
      else $text = __('стажировался(лась)');

      return $text;
    }

    $text = 'Я ';

    switch ($this->employment_alias) {

      case Model_Employment::VOLUNTEER:
        $text .= volunteer($this);
        $text .= ' ' . __('в');
        $text .= ' ' . $this->company->title;
        break;

      case Model_Employment::FULL:
        $text .= ' ' . work($this);
        $text .= ' ' . __('в');
        $text .= ' ' . $this->company->title;
        $text .= ' ' . __('на постояной основе');
        break;

      case Model_Employment::PART:
        $text .= ' ' . work($this);
        $text .= ' ' . __('в');
        $text .= ' ' . $this->company->title;
        $text .= ' ' . __('формате частичной занятости');
        break;

      case Model_Employment::PROBATION:
        $text .= ' ' . probation($this);
        $text .= ' ' . __('в');
        $text .= ' ' . $this->company->title;
        break;

      case Model_Employment::PROJECT:
        $text .= ' ' . work($this);
        $text .= ' ' . __('в');
        $text .= ' ' . $this->company->title;
        $text .= ' ' . __('на временной основе');
        break;

      case Model_Employment::WATCH:
        $text .= ' ' . work($this);
        $text .= ' ' . __('в');
        $text .= ' ' . $this->company->title;
        $text .= ' ' . __('вахтовым методом');
        break;
    }

    //добавляем про стаж
    if ($this->stage->loaded()) $text .= ' ' . mb_strtolower($this->stage->title);

    $text .= '. ';

    //добавляем рекомендую/не рекомендую для работы
    if ($this->recommend) {
      $text .= ' ' . __('Я рекомендую работать здесь.');
    }

    return $text;
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
    $review_date = strtotime($this->added);
    $datediff = $now - $review_date;
    return floor($datediff / (60 * 60 * 24));
  }

  /**
   * @param Validation|null $validation
   * @return Model_Review
   * @throws Kohana_Exception
   */
  //public function save(Validation $validation = null) {
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
  //
  //public function delete() {
  //
  //  //удалить активность
  //  if ($this->activity->loaded()) $this->activity->delete();
  //
  //  $review_company = $this->company;
  //  $review_position = $this->position;
  //
  //  //при удалении пересчитать количество активных зарплат у професии и компании
  //  $need_recount_reviews_at_position = ($this->status == Status::APPROVED) && $this->position->loaded();
  //  $need_recount_reviews_at_company = ($this->status == Status::APPROVED) && $this->company->loaded();
  //
  //  $res = parent::delete();
  //
  //  //recount
  //  if ($need_recount_reviews_at_position) $review_position->recount_reviews();
  //  if ($need_recount_reviews_at_company) $review_company->recount_reviews()->recount_rating();
  //
  //  return $res;
  //}

  public function admin_url() {
    if (!$this->loaded()) return "#";
    return "http://$_SERVER[HTTP_HOST]/admin/review/item/{$this->id}";
  }

  /**
   * @return Model_Review_Comment
   */
  public function get_company_comment() {

    $res = DB::select('user_id')
      ->from('users_companies')
      ->where('company_id', '=', $this->company_id)
      ->execute()
      ->as_array();

    $user_ids = [];
    foreach ($res as $row) {
      $user_ids[] = $row['user_id'];
    }

    $query = $this->comments->order_by('review_comment.updated', 'DESC');
    if (count($user_ids)) $query->where('review_comment.user_id', 'IN', $user_ids);

    $comment = $query->find();

    return $comment;

  }

  /**
   * @return $this
   */
  public function sync_activity() {

    /** @var Model_Activity $activity */
    $activity = $this->activity;
    if (!$activity->loaded()) {
      $activity = ORM::factory('Activity');
    }

    $activity->type = 'review';
    $activity->review = $this;
    $activity->anonym = $this->anonym;
    $activity->company = $this->company;
    $activity->user = $this->user;
    $activity->status = $this->status;
    $activity->save();

    return $this;
  }

}