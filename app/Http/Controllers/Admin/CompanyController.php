<?php

namespace App\Http\Controllers\Admin;

use App\Model\Company;
use App\Regex;
use Illuminate\Http\Request;
use Session;
use View;

class CompanyController extends AdminController {

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'company');
  }

  protected $itemsPerPage = 100;

  protected $object_name = 'Company';
  protected $sort_field = 'date';
  protected $sort_direction = 'DESC';

  //list of companies
  public function list(Request $request) {

    $title = __('Все компании');
    $activeTab = 'all';
    $query = Company::query();

    $search = $request->input('search');

    //$page = Arr::get($_GET, 'page', 1);
    //$offset = ($page - 1) * $this->item_per_page;
    //
    //$query = ORM::factory($this->object_name)
    //  //кол-во отзывов
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT r.id) FROM reviews r WHERE r.company_id = company.id)"),
    //    'total_reviews_count',
    //  ])
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT r.id) FROM reviews r WHERE r.company_id = company.id AND r.status = 'pending')"),
    //    'pending_reviews_count',
    //  ])
    //  //кол-во зарплат
    //  ->select([
    //    DB::expr('(SELECT COUNT(DISTINCT s.id) FROM salaries s WHERE s.company_id = company.id)'),
    //    'total_salaries_count',
    //  ])
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT s.id) FROM salaries s WHERE s.company_id = company.id AND s.status = 'pending')"),
    //    'pending_salaries_count',
    //  ])
    //  //кол-во собеседований
    //  ->select([
    //    DB::expr('(SELECT COUNT(DISTINCT i.id) FROM interviews i WHERE i.company_id = company.id)'),
    //    'total_interviews_count',
    //  ])
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT i.id) FROM interviews i WHERE i.company_id = company.id AND i.status = 'pending')"),
    //    'pending_interviews_count',
    //  ])
    //  //кол-во вакансий
    //  ->select([
    //    DB::expr('(SELECT COUNT(DISTINCT j.id) FROM jobs j WHERE j.company_id = company.id)'),
    //    'total_jobs_count',
    //  ])
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT j.id) FROM jobs j WHERE j.company_id = company.id AND j.status = 'pending')"),
    //    'pending_jobs_count',
    //  ])
    //  //кол-во фотографий
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT ci.img_id) FROM company_images ci WHERE ci.company_id = company.id)"),
    //    'total_images_count',
    //  ])
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT i.id) FROM company_images ci LEFT JOIN images i ON ci.img_id = i.id WHERE ci.company_id = company.id AND i.status = 'pending')"),
    //    'pending_images_count',
    //  ])
    //  //кол-во работодателей
    //  ->select([
    //    DB::expr("(SELECT COUNT(DISTINCT uc.user_id) FROM users_companies uc WHERE uc.company_id = company.id)"),
    //    'employers_count',
    //  ]);

    //фильтр по поисковой строке
    if (!empty($search)) {
      $query->search($search);
    }

    //фильтр "Новые компании"
    if ($request->input('notActive')) {
      $title = __('Новые компании');
      $activeTab = 'notActive';
      $query->notActive();
    }

    //фильтр "Не подтвержденные"
    if ($request->input('unconfirmed')) {
      $title = __('Не подтвержденные компании');
      $activeTab = 'unconfirmed';
      $query->unconfirmed();
    }

    //$total = $query->reset(false)->count_all();
    //$companies = $query
    //  ->order_by('pending_reviews_count', 'DESC')
    //  ->order_by('pending_salaries_count', 'DESC')
    //  ->order_by('pending_interviews_count', 'DESC')
    //  ->order_by('pending_images_count', 'DESC')
    //  ->order_by('last_updated', 'DESC')
    //  ->limit($this->item_per_page)
    //  ->offset($offset)
    //  ->find_all();

    $companies = $query->paginate($this->itemsPerPage);


    return view("admin.company.companies", [
      'title'     => $title,
      'search'    => $search,
      'companies' => $companies,
      'activeTab' => $activeTab,
    ]);
  }

  public function create() {

    $company = new Company();

    return view('admin.company.create', [
      'company' => $company,
    ]);
  }

  public function edit($id) {
    $company = Company::find($id);
    if (!$company) {
      session('message_error', "Компания не найдена");
      return redirect(route('admin.companies'));
    }

    return view('admin.company.edit', [
      'company'   => $company,
      'activeTab' => 'main',
    ]);
  }

  public function store(Request $request) {

    /** @var Company $company */
    $company = Company::findOrNew($request->input('id'));

    $aliasRegex = Regex::ALIAS;

    $this->validate($request, [
      'title' => "required|unique:companies,title,$company->id",
      'site'  => "required|url|active_url",
      'alias' => "required|max:32|regex:$aliasRegex|unique:companies,alias,$company->id",
    ]);

    $is_new = !$company->exists;

    //todo stop here: save company city

    //сохраняем данные
    $company->title = $request->input('title');
    $company->active = $request->input('active') ? true : false;
    $company->confirmed = $request->input('confirmed') ? true : false;
    $company->short_desc = $request->input('short_desc');
    $company->site = $request->input('site');
    $company->alias = $request->input('alias');
    $company->size_id = $request->input('size');
    $company->revenue_id = $request->input('revenue');
    $company->hq_city_id = $request->input('city');
    $company->foundation_year = $request->input('foundation_year');
    $company->description = $request->input('description');
    $company->save();

    $this->uploadImage($company, 'logo');
    $this->uploadImage($company, 'cover');

    //update industries
    //$company->remove('industries');
    //$industries = explode(',', Arr::get($_POST, 'industries'));
    //foreach ($industries as $title) {
    //  if ($title) {
    //    /** @var Model_Industry $industry */
    //    $industry = ORM::factory('Industry', ['title' => $title]);
    //    if (!$industry->loaded()) {
    //      $industry->title = $title;
    //      $industry->approved = true;
    //      $industry->save();
    //    }
    //    $company->add('industries', $industry);
    //  }
    //}

    $message = $is_new ? 'Компания успешно добавлена' : 'Компания успешно обновлена';
    session(['message_success' => $message]);

    return redirect()->intended(route('admin.company.edit', $company->id));
  }

  //фотографии компании
  public function images(Request $request) {

    /** @var Company $company */
    $company = Company::find($request->route('id'));

    if (!$company) {
      Session::put('message_error', __('Компания не найдена'));
      return redirect(route('admin.companies'));
    }

    $page = $request->query('page', 1);
    $offset = ($page - 1) * $this->itemsPerPage;

    /** @var Model_Image[] $images */
    $images = $company->images()
      ->offset($offset)
      ->orderBy('company_images.sort')
      ->orderBy('images.created_at', 'DESC')
      ->paginate($this->itemsPerPage);

    //$total = $company->images->count_all();

    $title = __('Фотографии компании') . " " . $company->ofCompany();

    return view("admin.company.images", [
      'title'     => $title,
      'company'   => $company,
      'images'    => $images,
      'activeTab' => 'images'
      //'total'      => $total,
      //'pagination' => $this->get_pagination($total),
    ]);

    $this->main_js = '/js/admin/image/list.js'; //todo

  }

  //добавить фотографию для компании
  public function addImages(Request $request) {

    /** @var Company $company */
    $company = Company::find($request->input('company'));

    if (!$company) {
      Session::put('message_error', __('Компания не найдена'));
      return redirect(route('admin.companies'));
    }

    $this->uploadImages($company);

    //if ($added_images_count) { //todo session success message
    //  Session::instance()->set('message_success', __('Для компании :for_company :added :count :images', [
    //    ':for_company' => $company->for_company,
    //    ':added'       => $added_images_count == 1 ? __('добавлена') : __('добавлено'),
    //    ':count'       => $added_images_count,
    //    ':images'      => Text::getNumEnding($added_images_count, [__('фотография'), __('фотографии'), __('фотографий')]),
    //  ]));
    //}

    return redirect(route('admin.company.images', $company));
  }


  //add, edit company
  public function action_item() {

    /** @var $company Model_Company */
    $company = ORM::factory($this->object_name, $this->request->param('id')); //for edit
    $is_new = false;
    $errors = [];

    if (!$company->loaded()) {
      $is_new = true;
      $company = ORM::factory($this->object_name); //for create new
    }

    //словари
    $sizes = ORM::factory('Company_Size')->order_by('sort')->find_all();
    $revenues = ORM::factory('Company_Revenue')->order_by('sort')->find_all();
    $countries = ORM::factory('Country')->order_by('title')->find_all();
    $cities = $company->hq->country->cities->order_by('title')->find_all();

    $view = View::factory("admin/{$this->lower_object_name}/item", [
      'company'    => $company,
      'errors'     => $errors,
      'sizes'      => $sizes,
      'revenues'   => $revenues,
      'countries'  => $countries,
      'cities'     => $cities,
      'industries' => implode_tags($company->industries->find_all()),
    ]);

    $this->title = $is_new ? __('Добавить компанию') : $company->title;
    $this->template->content = $view;
    $this->main_js = '/js/admin/company/item.js';
  }

  //добавить директора
  public function action_attachCeo() {

    /** @var Model_Company $company */
    $company = ORM::factory('Company', Arr::get($_POST, 'company'));

    $step_1_success = false; // шаг 1 - успешно нашли CEO
    $step_2_success = false; // шаг 2 - успешно прикрепили к компании

    if ($company->loaded()) {

      //добавляем существующего CEO
      /** @var Model_Person $ceo */
      $ceo = ORM::factory('Ceo', Arr::get($_POST, 'ceo'));
      $step_1_success = true; // шаг 1 - успешно нашли CEO (предположим)

      if (!$ceo->loaded()) {

        $step_1_success = false;

        //создать нового CEO
        /** @var Model_Ceo $ceo */
        $ceo = ORM::factory('Ceo');
        $ceo->firstname = Arr::get($_POST, 'firstname');
        $ceo->lastname = Arr::get($_POST, 'lastname');

        try {
          $ceo->save();
          $this->add_image($ceo, 'avatar');
          $step_1_success = true;
        } catch (ORM_Validation_Exception $e) {
        }
      }

      if ($step_1_success) {
        try {
          $ceo->company = $company;
          $ceo->save();
          $step_2_success = true;
        } catch (ORM_Validation_Exception $e) {
        }
      }

    }

    if ($step_1_success && $step_2_success) {
      Session::instance()->set('message_success', __('CEO успешно добавлен'));
    } else {
      Session::instance()->set('message_error', __('Не удалось добавить CEO'));
    }

    HTTP::redirect(URL::get_redirect_url());

  }

  //удалить CEO компании
  public function action_removeCeo() {
    /** @var Model_Company $company */
    $company = ORM::factory('Company', Arr::get($_POST, 'company'));
    if ($company->loaded() && $company->ceo->loaded()) $company->ceo->delete();
  }

  public function delete(Request $request) {
    $company = Company::find($request->input('id'));
    if ($company) $company->delete();
  }

}