<?php

namespace App\Model;

use App\Status;
use Illuminate\Database\Eloquent\Model;
use DB;
use Mockery\Exception;


/**
 * App\Model\Job
 *
 * @property int $id
 * @property string $title заголовок
 * @property int|null $position_id должность
 * @property int|null $employment_form_id форма занятости
 * @property int|null $stage_id опыт работы
 * @property float|null $salary_min мин зарплата
 * @property float|null $salary_max макс зарплата
 * @property int $has_additional_payments есть ли дополнительные выплаты
 * @property int|null $currency_id валюта зарплаты
 * @property string|null $description описание
 * @property int $company_id компания
 * @property int|null $user_id пользователь создавший вакансию
 * @property string $status статус вакансии: approved - одобрена, pending - в ожинании, rejected - отконена, draft - черновик
 * @property int $is_internship является ли стажировкой
 * @property int $hot горячая вакансия
 * @property string|null $external_url внешняя ссылка на вакансию
 * @property string|null $apply_type тип отклика: переход по внешней по ссылке, показать контакты, внутренняя
 * @property string|null $contacts контактные данные
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\City[] $cities
 * @property-read \App\Model\City $city
 * @property-read \App\Model\Company $company
 * @property-read \App\Model\Currency $currency
 * @property-read \App\Model\EmploymentForm|null $employmentForm
 * @property-read \App\Model\Position|null $position
 * @property-read \App\Model\Stage|null $stage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Tag[] $tags
 * @property-read \App\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job internships()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job notInternships()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job ofActiveCompanies()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job ofCompany($company)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job selectHasSalary()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job selectIsGoodCity($city, $readyMove = false, $readyRemote = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job selectIsGoodEmploymentForm($employmentForms)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job selectIsGoodPosition($position)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job selectIsGoodSalary($salary)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job selectTotalComfort($jobPreferences)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job status($status)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereApplyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereEmploymentFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereExternalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereHasAdditionalPayments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereHot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereIsInternship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereSalaryMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereSalaryMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Job whereUserId($value)
 * @mixin \Eloquent
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
   * добавить к выборке поле is_good_position
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param Position|null $position
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSelectIsGoodPosition($query, $position) {
    if ($position) {
      $query->select(DB::raw("if(jobs.position_id = {$position->id}, true, false) as is_good_position"));
    } else {
      $query->select(DB::raw('false as is_good_position'));
    }

    return $query;
  }

  /**
   * добавить к выборке поле is_good_city
   * город считать подходящим: если я готов к переезду или вакансия в нужном городе или если вакансия удаленная и я готов к удаленной работе
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param City|null $city
   * @param bool $readyMove
   * @param bool $readyRemote
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSelectIsGoodCity($query, $city, $readyMove = false, $readyRemote = false) {

    /** @var EmploymentForm $remoteEmploymentForm */
    $remoteEmploymentForm = EmploymentForm::where('alias', '=', EmploymentForm::REMOTE)->first();
    if (!$remoteEmploymentForm) throw new Exception("remote employment form not found");

    $orConditions = [
      "$readyMove",
      "($readyRemote and jobs.employment_form_id = '{$remoteEmploymentForm->id}')",
    ];

    if ($city) $orConditions[] = "(jobs_cities.city_id = $city->id)";

    $ifExpression = join(' or ', $orConditions);

    $query->select(DB::raw("if($ifExpression, true, false) as is_good_city"));

    return $query;
  }

  /**
   * добавить к выборке поле has_salary
   * зарплата считается указанной если указано хотябы одно поле из: salary_min или salary_max
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSelectHasSalary($query) {
    return $query->select(DB::raw("if(jobs.salary_min or jobs.salary_max, true, false) as has_salary"));
  }

  /**
   * добавить к выборке поле is_good_salary
   * зарплата считается указанной если указано хотябы одно поле из: salary_min или salary_max
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param float|null $salary
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSelectIsGoodSalary($query, $salary) {
    if ($salary) {
      $ifExpression = $this->join(' or ', [
        "(jobs.salary_min and jobs.salary_min >= $salary)",
        "(jobs.salary_max and jobs.salary_max >= $salary)",
      ]);
      $query->select(DB::raw("if($ifExpression, true, false) as is_good_salary"));
    } else {
      $query->select([DB::raw('FALSE'), 'is_good_salary']);
    }

    return $query;
  }

  /**
   * добавить к выборке поле is_good_employment_form
   * форма занятости считается хорошей если она входит массив id-шников $employmentForms
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param \Illuminate\Support\Collection|\App\Model\EmploymentForm[] $employmentForms
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSelectIsGoodEmploymentForm($query, $employmentForms) {
    if ($employmentForms->count()) {
      $employmentFormsIds = $employmentForms->implode('id', ',');
      //todo если у работы не указана форма занятости - то тоже хорошая
      //todo если пустой массив $employmentForms - то тоже любая форма будет считаться хорошей
      $query->select(DB::raw("if(find_in_set(jobs.employment_form_id, {$employmentFormsIds}), true, false) as is_good_employment_form"));
    } else {
      $query->select(DB::raw('false as is_good_employment_form'));
    }

    return $query;
  }

  /**
   * добавить к выборке поле total_comfort
   * общий уровень комфорта высчитывается согласно предпочтениям
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param \App\Model\JobPreferences $jobPreferences
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSelectTotalComfort($query, $jobPreferences) {

    //подходящая ли должность?
    $query->selectIsGoodPosition($jobPreferences->position);

    //подходящая ли форма занятости?
    $query->selectIsGoodEmploymentForm($jobPreferences->employmentForms);

    //подходящая ли зарплата?
    $query->selectIsGoodSalary($jobPreferences->salary);

    //подходящий ли город?
    $query->selectIsGoodCity($jobPreferences->city, $jobPreferences->ready_move, $jobPreferences->readyRemote());

    return $query->select(DB::raw("(is_good_position + is_good_employment_form + is_good_salary + is_good_city) as total_comfort"));
  }

  /**
   * Scope a query to only jobs of specific company
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param  int|Company|string $company
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
   * Scope a query to only jobs of active companies
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfActiveCompanies($query) {
    return $query->rightJoin('companies', function ($join) {
      $join->on('jobs.company_id', '=', 'companies.id')->where('companies.active', '=', true);
    })->select('jobs.*');
  }

  /**
   * Scope a query to only jobs with specific status
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $status
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeStatus($query, $status) {
    return $query->where('status', '=', $status);
  }

  /**
   * Scope a query to only approved jobs
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeApproved($query) {
    return $query->status(Status::APPROVED);
  }

  /**
   * Scope a query to only jobs, which are not internships
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeNotInternships($query) {
    return $query->where('is_internship', 'is', null)
      ->orWhere('is_internship', '=', false);
  }

  /**
   * Scope a query to only jobs, which are internships
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeInternships($query) {
    return $query->where('is_internship', '=', true);
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
      ->select([DB::raw('IF(job.salary_max, job.salary_max, job.salary_min)'), 'salary_order']);

    //выборка похожих вакансий (по профессии)
    $query->and_where('job.position_id', '=', $this->position_id);

    //не является базовой вакансией
    $query->and_where('job.id', '<>', $this->id);

    if ($curr_user) {
      $is_applied_expr = DB::raw("(SELECT COUNT(ja.id) FROM job_applications ja WHERE ja.job_id = job.id AND ja.user_id = :curr_user_id)");
      $query->select([$is_applied_expr, 'applied']);
      $query->and_where($is_applied_expr, '=', false); //выбираем только те, на которые я еще не отликался
    } else {
      $query->select([DB::raw("FALSE"), 'applied']);
    }

    //является избранной, для авторизованных
    if ($curr_user) {
      $query->select([DB::raw("(SELECT COUNT(*) FROM faves_jobs fj WHERE fj.job_id = job.id AND fj.user_id = :curr_user_id)"), 'is_fave']);
    } else {
      $query->select([DB::raw("FALSE"), 'is_fave']);
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

  public function shareEmailParams() {
    $subject = __(':job', [':job' => $this->title, ':for_company' => $this->company->for_company]);
    $text = __('Я нашел интересную вакансию для тебя:') . " {$subject} ➜ {$this->url()}";
    return ['subject' => $subject, 'text' => $text];
  }

  public function metaImage() {
    return $this->company->logo ? $this->company->logo->resize(200, 200)->path : null;
  }

  public function meta() {

    $image = $this->metaImage();

    $meta = new PageMeta();
    $meta
      ->setUrl($this->url)
      ->setType('article')
      ->setTitle($this->title)
      ->setDescription($this->noHtmlDescription())
      ->setImage($image);

    return $meta;

  }

}