<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Interview
 *
 * @property int                    id
 * @property string                 title                    - названеи собеседование (virtual)
 * @property string                 subtitle                 - подзаголовок собеседование (virtual)
 * @property string                 url                      - ссылка на собеседование (virtual)
 * @property string                 alias
 * @property string                 status                   - код статуса собеседования @see modules/enums/classes/Status.php
 * @property int                    process_experience       - впечатление от собеседования @see modules/enums/classes/Opinion.php
 * @property string                 $description             - описание процесса собеседования
 * @property int                    difficulty               - сложность от 1 до 5
 * @property int                    interview_outcome        - результат собеседования: 1 - да; 2 - да, но отказался; 3 - нет
 * @property int                    $duration_number         - длительность процесса величина
 * @property string                 $duration_unit           - длительность процесса, ед измер ('day','week','month')
 * @property int                    month                    - когда было: месяц
 * @property int                    year                     - когда было: год
 * @property int                    we_help                  - как наш сервис помог
 * @property string                 added                    - дата добавления
 * @property string                 last_updated             - дата последних изменений
 * @property string                 $step_other              - дополнительный шаг собеседования
 *
 * @property Model_Company          company                  - компания
 * @property int                    company_id
 *
 * @property Model_Interview_Source source                   - источник собеседования
 * @property int                    source_id
 * @property string                 source_specify           - уточнение источника собеседования (дополнительне поле)
 *
 * @property Model_User             user                     - кто добавил
 * @property int                    user_id
 *
 * @property Model_User             last_updated_user        - кем были сделаны последние изменения
 * @property int                    last_updated_user_id
 *
 * @property Model_Position         position                 - на какую должность проходило собеседование
 * @property int                    position_id
 * @property string                 position_title           - запасное поле
 *
 * @property Model_City             city                     - где проходило собеседование
 * @property int                    city_id
 * @property string                 city_title               - черновое поле
 *
 *------------------------------ СОДЕРЖИТ МНОЖЕСТВА --------------------------------------------
 * @property ORM                    questions                - вопросы собеседования
 * @property ORM                    steps                    - проделанные шаги собеседования
 * @property ORM                    comments                 - комментарии к собеседованию (ответы)
 *
 */
class Interview extends Model {

  public function company() {
    return $this->belongsTo('App\Model\Company');
  }

  public function source() {
    return $this->belongsTo('App\Model\InterviewSource');
  }

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  //todo relations
  protected $_has_many = [
    'questions' => [
      'model'       => 'Interview_Question',
      'foreign_key' => 'interview_id',
    ],
    'steps'     => [
      'model'       => 'Interview_Step',
      'foreign_key' => 'interview_id',
      'far_key'     => 'step_id',
      'through'     => 'steps_in_interviews',
    ],
    'comments'  => [ //todo morph relation
      'model'       => 'Interview_Comment',
      'foreign_key' => 'for_id',
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
  //  /** @var Model_Company $company */
  //  $company = $this->company;
  //  /** @var Model_Position $position */
  //  $position = $this->position;
  //
  //  $approved = $this->status == Status::APPROVED;
  //
  //  $delete_res = parent::delete();
  //
  //  if ($approved) {
  //    //пересчитать количество собеседований у компаний
  //    $company->recount_interviews();
  //
  //    //пересчитать количество собеседований у должности
  //    $position->recount_interviews();
  //  }
  //
  //  return $delete_res;
  //}
  //
  //public function get($column) {
  //  switch ($column) {
  //    case 'title':
  //      return $this->get_title();
  //      break;
  //    case 'subtitle':
  //      return $this->get_subtitle();
  //      break;
  //    case 'url':
  //      return $this->get_url();
  //      break;
  //  }
  //
  //  return parent::get($column);
  //}

  /**
   * /kazcom/interview/my-best-interview
   * /kazcom/interview/1
   *
   * @param bool $full - Включить ли хост в url
   * @return string
   */
  public function get_url($full = true) {
    $url = "";
    if ($full) $url .= "http://$_SERVER[HTTP_HOST]";
    $url .= "/@{$this->company->alias}/interview/";
    $url .= $this->alias ? $this->alias : $this->id;
    return $url;
  }

  public function get_title() {
    if (I18n::$lang == 'ru') {
      $position_title = Morpher::inflect($this->position->title, 'Р');
    } else {
      $position_title = __($this->position->title);
    }

    return __('Собеседование :position', [':position' => $position_title]);
  }

  public function get_subtitle() {
    if ($this->interview_outcome == Opinion::POSITIVE) {
      $subtitle = __('Анонимный работник');
    } else {
      $subtitle = __('Анонимный кандидат');
    }
    if ($this->city->loaded()) {
      $subtitle .= ', ' . $this->city->title_regard_to_me();
    }
    return $subtitle;
  }

  public function get_logistic_desc() {

    $is_ru = I18n::$lang == 'ru';

    //<editor-fold desc="как пригласили">
    $source_sentence = null;
    if ($this->source->loaded()) {

      if ($this->source->specifiable && $this->source_specify) {
        //другое
        $source_sentence = mb_ucfirst($this->source_specify) . '.';

      } else {
        //все остальные стандартные исчтоники не требующие уточнения
        switch ($this->source_id) {

          //онлайн заявка
          case 1:
            $source_sentence = __('Я подал онлайн заявку.');
            break;

          //колледж или университет
          case 2:
            $source_sentence = __('Меня пригласили через учебное заведение.');
            break;

          //от сотрудника
          case 3:
            $source_sentence = __('Меня пригласил сотрудник компании.');
            break;

          //персонально
          case 4:
            $source_sentence = __('Я получил персональное приглашение.');
            break;

          //рекрутер
          case 5:
            $source_sentence = __('На меня вышел рекрутер компании.');
            break;

          //кадровое агентство
          case 6:
            $source_sentence = __('Компания вышла на меня через кадровое агентство.');
            break;

          default:
            $source_sentence = null;
            break;
        }
      }

    }
    //</editor-fold>

    //<editor-fold desc="когда и где проходило собеседование">
    $where_sentence = null;

    //когда
    $when = null;
    if ($this->month || $this->year) {
      $month_name = Month::text($this->month);
      $when = __("в :month :year", [
        ':month' => mb_strtolower($is_ru ? Morpher::inflect(__($month_name), 'П') : __($month_name)),
        ':year'  => $this->year ? $this->year . " " . __('года') : null,
      ]);
    }

    //где
    $where = null;
    if ($this->city->loaded()) {
      $city_title = $this->city->title;
      $where = __("в :city", [
        ':city' => $is_ru ? Morpher::inflect(__($city_title), 'П') : __($city_title),
      ]);
    }

    if ($when || $where) {
      $where_sentence = __("Собеседование проходило :when :where.", [
        ':when'  => $when,
        ':where' => $where,
      ]);
    }
    //</editor-fold>

    //<editor-fold desc="сколько времени занял процесс">
    $how_long_sentence = null;
    if ($this->duration_number && $this->duration_unit) {

      $number = $this->duration_number;

      switch ($this->duration_unit) {
        case Period::DAY:
          $unit = Text::getNumEnding($number, [__('день'), __('дня'), __('дней')]);
          break;
        case Period::WEEK:
          $unit = Text::getNumEnding($number, [__('неделю'), __('недели'), __('недель')]);
          break;
        case Period::MONTH:
          $unit = Text::getNumEnding($number, [__('месяц'), __('месяца'), __('месецев')]);
          break;
      }

      if (!empty($unit)) {
        $how_long_sentence = __('Весь процесс занял :number :unit.', [':number' => $number, ':unit' => $unit]);
      }
    }
    //</editor-fold>

    //<editor-fold desc="Проделанные шаги">
    $steps_sentence = null;
    $steps = [];
    /** @var Model_Interview_Step $step */
    foreach ($this->steps->order_by('sort')->find_all() as $step) {
      $steps[] = __(mb_strtolower($step->full_title));
    }
    if ($this->step_other) $steps[] = mb_strtolower($this->step_other);

    if (count($steps)) {
      $steps_sentence = __("Проделанные шаги: :steps.", [':steps' => implode(', ', $steps)]);
    }
    //</editor-fold>

    $sentences = [];
    if ($source_sentence) $sentences[] = $source_sentence;
    if ($where_sentence) $sentences[] = $where_sentence;
    if ($how_long_sentence) $sentences[] = $how_long_sentence;
    if ($steps_sentence) $sentences[] = $steps_sentence;

    if (count($sentences)) {
      return implode(' ', $sentences);
    }

    return null;
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

  public function save_interview(Model_User $user, Array $data = []) {

    /** @var Model_Interview $interview */
    $interview = ORM::factory('Interview', Arr::get($data, 'id'));
    $is_new_interview = !$interview->loaded();

    //выставляем данные
    $interview->process_experience = Arr::get($data, 'process_experience');
    $interview->description = Arr::get($data, 'description');
    $interview->difficulty = Arr::get($data, 'difficulty');
    $interview->interview_outcome = Arr::get($data, 'outcome');
    $interview->we_help = Arr::get($data, 'we_help');
    $interview->user = $user;
    $interview->status = Status::PENDING;

    //когда было
    if ($month = Arr::get($data, 'month')) $interview->month = $month;
    if ($year = Arr::get($data, 'year')) $interview->year = $year;

    //длительность
    if ($duration = Arr::get($data, 'duration_number')) {
      $interview->duration_number = $duration;
      $interview->duration_unit = Arr::get($data, 'duration_unit', Period::DAY);
    }

    //компания
    $interview->company = ORM::factory('Company', Arr::get($data, 'company_id'));

    //источник собеседования
    $interview->source = ORM::factory('Interview_Source', Arr::get($data, 'source_id'));
    if ($interview->source->loaded() && $interview->source->specifiable
      && $interview_source_specify = Arr::get($data, 'source_specify')
    ) {
      $interview->source_specify = $interview_source_specify;
    }

    //где проходило собеседование
    $city_title = Arr::get($data, 'city_title');
    /** @var Model_City $city */
    $city = ORM::factory('City')->where('title', 'LIKE', $city_title)->limit(1)->find();
    if ($city->loaded()) {
      $interview->city = $city;
      $interview->city_title = null;
    } else {
      $interview->city = null;
      $interview->city_title = $city_title;
    }

    //должность-профессия
    $position_title = Arr::get($data, 'position_title');
    /** @var Model_Position $position */
    $position = ORM::factory('Position')->where('title', 'LIKE', $position_title)->limit(1)->find();
    if ($position->loaded()) {
      $interview->position = $position;
      $interview->position_title = null;
    } else {
      $interview->position = null;
      $interview->position_title = $position_title;
    }

    $interview->save();

    //сохранить вопросы собеседования
    $interview->save_questions(Arr::get($data, 'questions', []));

    //сохранить шаги собеседования
    $steps_id = Arr::get($data, 'steps_id', []);
    $interview->save_steps($steps_id);
    //другой шаг
    if (in_array('other', $steps_id) && ($step_other = Arr::get($data, 'step_other'))) {
      $interview->step_other = $step_other;
    } else {
      $interview->step_other = null;
    }
    $interview->update();


    if ($is_new_interview) {

      //notify admin about new interview
      $app_name = Kohana::$config->load('app')->get('app_name');
      $subject = __('Новое собеседование на :app_name', [':app_name' => $app_name]);
      $email_html = View::factory('email/notify-interview', ['interview' => $interview, 'app_name' => $app_name])->render();
      Email::instance()->send_admin($subject, $email_html);

    } else {

      //todo notify admin about update interview

    }

    return $interview;
  }

  public function save_steps($steps_id) {
    foreach ($steps_id as $step_id) {
      if (($step_id != 'other') && !$this->has('steps', $step_id)) {
        $this->add('steps', $step_id);
      }
    }

    /** @var Model_Interview_Step $step */
    foreach ($this->steps->find_all() as $step) {
      if (!in_array($step->id, $steps_id)) {
        $this->remove('steps', $step->id);
      }
    }

  }

  public function save_questions(Array $questions = []) {

    if (!count($questions)) return;

    $num = $this->questions->order_by('number', 'DESC')->find()->number;
    if (!$num) $num = 1;

    $arr_id = [];

    foreach ($questions as $data) {

      $id = Arr::get($data, 'id');
      $text = Arr::get($data, 'text');
      $answer_text = Arr::get($data, 'answer');

      if ($id) $arr_id[] = $id;

      /** @var Model_Interview_Question $question */
      $question = ORM::factory('Interview_Question', $id);

      if ($text) {

        //добавить|обновить вопрос
        $question->text = $text;
        $question->number = $num++;
        $question->interview_id = $this->id;
        $question->save();

        /** @var Model_Interview_Answer $answer */
        $answer = ORM::factory('Interview_Answer')
          ->where('question_id', '=', $question->id)
          ->and_where('user_id', '=', $this->user->id)
          ->find();

        if (!$answer->loaded()) {
          $answer = ORM::factory('Interview_Answer');
          $answer->question_id = $question->id;
          $answer->user_id = $this->user->id;
        }

        if ($answer_text) {
          $answer->text = $answer_text;
          $answer->save();
        }
        //
        //удалить ответ
        elseif ($answer->loaded()) $answer->delete();

      }
      //
      //удалить вопрос
      elseif ($question->loaded()) $question->delete();

    }


    //delete if id not passed
    /** @var Model_Interview_Question $question */
    foreach ($this->questions->find_all() as $question) {
      if (!in_array($question->id, $arr_id)) {
        $question->delete();
      }
    }

  }

  public function admin_url() {
    if (!$this->loaded()) return "#";
    return "/admin/interview/item/{$this->id}";
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

    $query = $this->comments->order_by('interview_comment.updated', 'DESC');
    if (count($user_ids)) $query->where('interview_comment.user_id', 'IN', $user_ids);

    $comment = $query->find();

    return $comment;

  }

}