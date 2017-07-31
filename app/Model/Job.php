<?php

namespace App\Model;

use App\Status;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Job Вакансия
 *
 * @property int     $id
 * @property string  $title                   - заголовок вакансии
 * @property int     $salary_min              - мин зарплата
 * @property int     $salary_max              - макс зарплата
 * @property boolean $has_additional_payments - есть ли дополнительные выплаты
 * @property string  $description             - описание
 * @property string  $added                   - дата добавления вакансии
 * @property string  $status                  - статус
 * @property boolean $is_internship           - является ли стажировкой
 * @property boolean $hot                     - горячая вакансия
 * @property string  $apply_type              - тип отклика: переход по внешней по ссылке, показать контакты, внутренняя
 * @property string  $external_url            - внешней url
 * @property string  $contacts                - контактные данные
 * @property string  $employment_form_id      - id формы занятости
 * @property int     $stage_id                - стаж работы
 * @property int     $position_id             - должность
 * @property string  $currency_id             - валюта зарпаты
 * @property int     $company_id              - компания
 * @property int     $user_id                 - пользователь создавший вакансию
 *
 * ------------------------------- virtual -------------------------------------------
 *
 * @property string  $url                     - ссылка на страницу вакансии
 * @property string  $similar_url             - ссылка на страницу похожих вакансий
 *
 * ------------------------------- has many -------------------------------
 *
 * @property ORM     $industries              - направления деятельности
 * @property ORM     $tags                    - теги
 * @property ORM     $cities                  - города
 * @property ORM     $applications            - заявки
 */
class Job extends Model {

  public function position() {
    return $this->belongsTo('App\Model\Position');
  }

  public function employmentForm() {
    return $this->belongsTo('App\Model\EmploymentForm', 'employment_form_id');
  }

  public function stage() {
    return $this->belongsTo('App\Model\Stage');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function currency() {
    return $this->belongsTo('App\Model\Currency');
  }

  public function company() {
    return $this->belongsTo('App\Model\Company');
  }

  public function user() {
    return $this->belongsTo('App\Model\User');
  }

  public function tags() {
    return $this->morphToMany('App\Model\Tag', 'taggable');
  }

  public function cities() {
    return $this->belongsToMany('App\Model\City', 'jobs_cities');
  }

  //todo relations
  protected $_has_many = [
    'industries'   => [
      'model'       => 'Industry',
      'foreign_key' => 'job_id',
      'far_key'     => 'industry_id',
      'through'     => 'jobs_industries',
    ],
    'applications' => [
      'model'       => 'Job_Application',
      'foreign_key' => 'job_id',
    ],
  ];

  /**
   * Scope a query to only jobs of specific company
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param  int|Company|string                   $company
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfCompany($query, $company) {
    if (is_numeric($company)) {
      return $query->where('company_id', '=', $company);
    } elseif ($company instanceof Company) {
      return $query->where('company_id', '=', $company->id);
    }
    //todo join for company title like query
    return $query;
  }

  /**
   * Scope a query to only jobs with specific status
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string                                $status
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeStatus($query, $status) {
    return $query->where('status', '=', $status);
  }

  public function filters() {
    return [
      'description' => [
        ['clear_style'],
      ],
    ];
  }

  public function rules() { //todo validation
    return [
      'contacts' => [
        // contacts must be not empty if is job's apply type = 'contacts'
        [function ($contacts, Validation $validation, $field) {
          if ($this->apply_type == 'contacts' && !$contacts) {
            $validation->error($field, 'not_empty');
          }
        }, [':value', ':validation', ':field']],
      ],
    ];
  }

  //public function create(Validation $validation = null) {
  //  $this->added = date("Y-m-d H:i:s");
  //  $this->user = Auth::instance()->get_user();
  //  return parent::create($validation);
  //}

  //public function delete() {
  //
  //  $job_position = $this->position;
  //  $job_company = $this->company;
  //
  //  //при удалении пересчитать количество активных вакансий у компании
  //  $need_recount_jobs_at_position = ($this->status == Status::APPROVED) && $job_position->loaded();
  //  $need_recount_jobs_at_company = ($this->status == Status::APPROVED) && $job_company->loaded();
  //
  //  //delete applications
  //  foreach ($this->applications->find_all() as $application) $application->delete();
  //
  //  $res = parent::delete();
  //
  //  //recount
  //  if ($need_recount_jobs_at_position) $job_position->recount_jobs();
  //  if ($need_recount_jobs_at_company) $job_company->recount_jobs();
  //
  //  return $res;
  //}

  //public function get($column) {
  //  switch ($column) {
  //    case 'similar_url':
  //      return $this->url . '/similar';
  //      break;
  //  }
  //  return parent::get($column);
  //}

  public function url() {
    if ($this->status != Status::APPROVED) return '#';
    if (!$this->company) return "#";
    if (!$this->company->active) return "#";

    $url = "/{$this->company->alias}/job";
    if ($this->position) $url .= "/{$this->position->alias}";
    $url .= "/{$this->id}";
    return url($url);
  }

  public function noHtmlDescription() {

    $desc = $this->description;

    $desc = strip_tags($desc);
    $desc = str_replace("&nbsp;", " ", $desc);
    $desc = preg_replace('/\s+/u', " ", $desc);
    $desc = html_entity_decode($desc);

    return $desc;
  }

  public function admin_url() {
    if (!$this->loaded()) return '#';
    return "http://$_SERVER[HTTP_HOST]/admin/job/item/{$this->id}";
  }

  /**
   * @param int $limit
   * @return Model_Job[]
   */
  public function get_similar_jobs($limit = 10) {

    $curr_user = Auth::instance()->get_user();

    $query = ORM::factory('Job')
      ->where('job.status', '=', Status::APPROVED)# только одобренные
      //подкючаем компании
      ->join('company', 'LEFT')->on('job.company_id', '=', 'company.id')
      //определяем поле сортировки уровня зарплаты
      ->select([DB::expr('IF(job.salary_max, job.salary_max, job.salary_min)'), 'salary_order']);

    //выборка похожих вакансий (по профессии)
    $query->and_where('job.position_id', '=', $this->position_id);

    //не является базовой вакансией
    $query->and_where('job.id', '<>', $this->id);

    if ($curr_user) {
      $is_applied_expr = DB::expr("(SELECT COUNT(ja.id) FROM job_applications ja WHERE ja.job_id = job.id AND ja.user_id = :curr_user_id)");
      $query->select([$is_applied_expr, 'applied']);
      $query->and_where($is_applied_expr, '=', false); //выбираем только те, на которые я еще не отликался
    } else {
      $query->select([DB::expr("FALSE"), 'applied']);
    }

    //является избранной, для авторизованных
    if ($curr_user) {
      $query->select([DB::expr("(SELECT COUNT(*) FROM faves_jobs fj WHERE fj.job_id = job.id AND fj.user_id = :curr_user_id)"), 'is_fave']);
    } else {
      $query->select([DB::expr("FALSE"), 'is_fave']);
    }

    //сортировка
    $query
      ->order_by('is_fave')//избранные вконец
      ->order_by('company.rating', 'DESC')
      ->order_by('salary_order', 'DESC')
      ->order_by('job.added', 'DESC');

    if ($curr_user) {
      $query->param(':curr_user_id', $curr_user->id);
    }

    $jobs = $query->limit($limit)->find_all()->as_array();

    return $jobs;
  }

  /**
   * проверяет подавал ли пользователь заявку на эту вакансию
   *
   * @return bool|string - date of application
   */
  public function is_applied() {

    /** @var Model_User $curr_user */
    $curr_user = Auth::instance()->get_user();

    $applications_ids = Session::instance()->get(Session::JOBS_APPLICATIONS, []);

    /** @var Model_Job_Application $application */
    $application = ORM::factory('Job_Application')
      ->where('job_id', '=', $this->id)
      ->order_by('added', 'DESC');

    //поиск заявки
    if (Auth::instance()->logged_in()) {
      $application->and_where('user_id', '=', $curr_user->id);
    } elseif (count($applications_ids)) {
      $application->and_where('id', 'IN', $applications_ids);
    } else {
      return false;
    }

    $application = $application->find();

    $applied = $application->loaded() ? $application->added : false;

    return $applied;
  }

  public static function route_filter_id($route, $params, $request) {

    $id = Arr::get($params, 'job_id');
    $job = ORM::factory('Job', ['id' => $id, 'status' => Status::APPROVED]);
    $request->job = $job;

    if (!empty($id)) return $job->loaded();

    return null;
  }

  public function share_email() {
    $subject = __(':job', [':job' => $this->title, ':for_company' => $this->company->for_company]);
    $text = __('Я нашел интересную вакансию для тебя:') . " {$subject} ➜ {$this->url}";
    return ['subject' => $subject, 'text' => $text];
  }

  public function page_meta() {

    $image = $this->company->logo->loaded() ? $this->company->logo->resize(200, 200)->path : null;

    $page_meta = new PageMeta();
    $page_meta
      ->setUrl($this->url)
      ->setType('article')
      ->setTitle($this->title)
      ->setDescription($this->noHtmlDescription())
      ->setImage($image);

    return $page_meta;

  }

}