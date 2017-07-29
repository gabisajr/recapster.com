<?php

namespace App\Http\Controllers\Admin;

use App\Model\Company;
use App\Model\Job;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use View;

class JobController extends AdminController {

  protected $object_name = 'Job';
  protected $sort_field = 'added';
  protected $sort_direction = 'DESC';

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'job');
  }

  //list of jobs
  public function list(Request $request) {

    //база
    $query = Job::query();

    //фильтр по компании
    $company = Company::find($request->query('company'));
    if ($company) $query->company($company);

    //фильтр по статусу
    $status = $request->query('status');
    if (in_array($status, Status::$all)) {
      $query->status($status);
    } else $status = null;

    $jobs = $query
      ->orderBy('created_at', 'DESC')
      ->paginate(100);

    //для заголовка сверху
    //$total = ORM::factory($this->object_name)->count_all();

    if ($company) {
      $title = __("Вакансии :of_company", [':of_company' => $company->of_company]);
    } else {
      $title = __("Вакансии");
    }

    $counts = $this->countsGroups($company);

    return view("admin.job.jobs", [
      'company' => $company,
      'jobs'    => $jobs,
      'status'  => $status,
      'counts'  => $counts,
      'title'   => $title,
    ]);
  }

  /**
   * посчитать сколько вакансий с разным статусом
   * @param Company|null $company
   * @return Collection
   */
  private function countsGroups(Company $company = null) {

    if ($company) {
      $counts = [
        Status::PENDING  => Job::status(Status::PENDING)->company($company)->count(),
        Status::APPROVED => Job::status(Status::APPROVED)->company($company)->count(),
        Status::REJECTED => Job::status(Status::REJECTED)->company($company)->count(),
      ];
    } else {
      $counts = [
        Status::PENDING  => Job::status(Status::PENDING)->count(),
        Status::APPROVED => Job::status(Status::APPROVED)->count(),
        Status::REJECTED => Job::status(Status::REJECTED)->count(),
      ];
    }

    return new Collection($counts);
  }

  /** show form form create new job */
  public function create() {
    $job = new Job();
    return view("admin.job.create", [
      'job' => $job,
    ]);
  }

  public function edit(Request $request) {
    $job = Job::find($request->route('id'));
    return view("admin.job.edit", [
      'job' => $job,
    ]);
  }

  public function store(Request $request) {

    /** @var Job $job */
    $job = Job::findOrNew($request->input('id'));

    $this->validate($request, [
      'title'        => 'required',
      'position'     => 'required', //todo add db exists validator
      'company'      => 'required', //todo add db exists validator
      'description'  => 'required', //todo numeric, max
      'salary_min'   => 'nullable|numeric',
      'salary_max'   => 'nullable|numeric|greater_than:salary_min', //todo test custom 'greater_than'
      'external_url' => "nullable|required_if:apply_type,external|url|active_url|unique:jobs,external_url,$job->id",
      'contacts'     => 'nullable|required_if:apply_type,contacts', //todo test required_if
      'status'       => 'required', //todo in array
    ], [
      'company.required'     => 'Выберите компанию для которой добавляете вакансию',
      'title.required'       => 'Укажите заголовок вакансии',
      'position.required'    => 'Укажите должность',
      'description.required' => 'Опишите вакансию, требования, условия и т.д.',
      'status.required'      => 'Укажите статус вакансии',
    ]);

    $isNew = !$job->exists;
    $oldStatus = $job->status;

    $job->company_id = $request->input('company');
    $job->title = $request->input('title');
    $job->is_internship = (boolean)$request->input('is_internship');
    $job->hot = (boolean)$request->input('hot');
    $job->description = $request->input('description');
    $job->salary_min = (double)$request->input('salary_min');
    $job->salary_max = (double)$request->input('salary_max');
    $job->currency_id = $request->input('currency');
    $job->employment_form_id = $request->input('employment');
    $job->apply_type = $request->input('apply_type');
    $job->external_url = $request->input('external_url');
    $job->contacts = $request->input('contacts');
    $job->status = $request->input('status');
    $job->position_id = $request->input('position');

    $job->save();

    ////update tags
    //$job->remove('tags');
    //$tags = explode(',', Arr::get($_POST, 'tags'));
    //foreach ($tags as $title) {
    //  if ($title) {
    //    /** @var Model_Tag $tag */
    //    $tag = ORM::factory('Tag', ['title' => $title]);
    //    if (!$tag->loaded()) {
    //      $tag->title = $title;
    //      $tag->save();
    //    }
    //    $job->add('tags', $tag);
    //  }
    //}
    //
    ////update cities
    //$job->remove('cities');
    //$cities = explode(',', Arr::get($_POST, 'cities'));
    //foreach ($cities as $title) {
    //  if ($title) {
    //    $city = ORM::factory('City', ['title' => $title]);
    //    if ($city->loaded()) $job->add('cities', $city);
    //  }
    //}

    //if ($oldStatus != $job->status) { //todo event
    //  $job->position->recount_jobs();
    //  $job->company->recount_jobs();
    //}

    $message_success = $isNew ? __('Вакансия успешно добавлена') : __('Вакансия успешно обновлена');
    session(['message_success' => $message_success]);
    return redirect(route('admin.job.edit', $job));
    //HTTP::redirect("/admin/job/item/{$job->id}");
  }

  public function delete(Request $request) {
    $job = Job::find($request->input('id'));
    if ($job) $job->delete();
  }

  // update interview status todo delete
  public function action_status() {

    /** @var Model_Job $job */
    $job = ORM::factory($this->object_name, $this->request->param('id'));

    if (!$job->loaded()) {
      Session::instance()->set('message_error', __('Вакансия не найдена'));
      HTTP::redirect("/admin/job/list");
    }

    $old_status = $job->status;
    $new_status = Arr::get($_POST, 'status');

    if (!$job->position->loaded() && $new_status == Status::APPROVED) {
      Session::instance()->set('message_error', __('Вы не можете одобрить вакансию без профессии'));
      HTTP::redirect("/admin/job/info/$job->id");
    }

    $errors = [];
    try {
      $job->status = $new_status;
      $job->save();
    } catch (ORM_Validation_Exception $e) {
      $errors = $e->errors('models');
    }

    var_dump($errors);

    if ($job->status != $old_status) {
      Session::instance()->set('message_success', __('Статус вакансии успешно обновлен'));

      //пересчитать кол-во одобренных собеседований у профессии
      if ($job->position->loaded()) $job->position->recount_jobs();
      if ($job->company->loaded()) $job->company->recount_jobs();

      //отправить уведомление пользователю о том что вакансия одобрена
      if ($job->status == Status::APPROVED && $job->user->confirmed) {
        $subject = __('Ваша вкансия :position опубликована на :app_name', [
          ':position' => mb_strtolower(Morpher::inflect($job->position->title, 'Р')),
          ':app_name' => $this->app_name]);
        $email_html = View::factory('email/approved-job', ['job' => $job])->render();
        Email::instance()->send($job->user->email, $subject, $email_html);
      }
    }

    HTTP::redirect("/admin/job/info/$job->id");

  }

}