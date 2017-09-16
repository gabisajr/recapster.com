<?php

namespace App\Model;

use App\Status;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Review
 *
 * @property int $id
 * @property int $company_id для какой компании отзыв
 * @property string $text текст отзыва
 * @property int $active_employee отзыв от действующего сотрудника
 * @property int|null $rating общая оценка компании от респондента
 * @property int|null $position_id должность респондента
 * @property string|null $position_title должность респондента - строкой
 * @property string $status статус отзыва: approved - одобрен, pending - в ожинании, rejected - отконен
 * @property string|null $employment_form_alias форма занятости
 * @property int|null $recommend рекомендую ли работать
 * @property int|null $stage_id стаж работы
 * @property int|null $city_id местоположение офиса
 * @property string|null $city_title местоположение офиса - строкой
 * @property int|null $user_id пользователь оставивший отзыв
 * @property int $anonym отзыв является анонимным
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Company $company
 * @property-read \App\Model\EmploymentForm|null $employmentForm
 * @property-read \App\Model\Position|null $position
 * @property-read \App\Model\Stage|null $stage
 * @property-read \App\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review ofCompany($company)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review status($status)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereActiveEmployee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereAnonym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCityTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereEmploymentFormAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review wherePositionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Review whereUserId($value)
 * @mixin \Eloquent
 */
class Review extends Model {

  use Approvable;

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

  /**
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param Company|int $company
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfCompany($query, $company) {

    $companyId = null;
    if ($company instanceof Company) {
      $companyId = $company->id;
    } elseif (is_numeric($company)) {
      $companyId = $company;
    }

    if ($companyId) {
      return $query->where('company_id', '=', $companyId);
    } else {
      error_log("invalid company argument: value '$company', needs Company or int");
    }

    return $query;
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

  //public function get($column) {
  //  switch ($column) {
  //    case 'activity': //todo add activity relation
  //      return $this->get_activity();
  //      break;
  //  }
  //
  //  return parent::get($column);
  //}


  public function url() {
    if (!$this->company->active) return '#';
    return "http://$_SERVER[HTTP_HOST]/{$this->company->alias}/review/{$this->id}"; //todo route
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

  ///**
  // * @param Validation|null $validation
  // * @return Model_Review
  // * @throws Kohana_Exception
  // */
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