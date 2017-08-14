<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use View;

class UsersController extends AdminController {

  /** @var  Model_User */
  protected $user;

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'users');
  }

  //list of users
  public function list(Request $request) {

    $query = User::query()
      ->distinct()
      //->join('roles_users')->on('roles_users.user_id', '=', 'user.id')
      //->join('roles')->on('roles.id', '=', 'roles_users.role_id')
      //количество отзывов пользователя
      //->select([
      //  DB::expr("(SELECT COUNT(DISTINCT reviews.id) FROM reviews WHERE reviews.user_id = user.id)"),
      //  'reviews_count',
      //])
      ////количество собеседований пользователя
      //->select([
      //  DB::expr("(SELECT COUNT(DISTINCT interviews.id) FROM interviews WHERE interviews.user_id = user.id)"),
      //  'interviews_count',
      //])
      ////кол-вол зарплат пользователя
      //->select([
      //  DB::expr("(SELECT COUNT(DISTINCT salaries.id) FROM salaries WHERE salaries.user_id = user.id)"),
      //  'salaries_count',
      //])
      ////кол-во фотографий пользователя
      //->select([
      //  DB::expr("(SELECT COUNT(DISTINCT images.id) FROM images WHERE images.user_id = user.id AND images.parent_id IS NULL)"),
      //  'images_count',
      //])
      ////кол-во компаний, на которые подписан
      //->join('subscriptions', 'LEFT')->on('subscriptions.user_id', '=', 'user.id')
      //->select([DB::expr("COUNT(DISTINCT subscriptions.id)"), 'subscriptions_count'])
      //->group_by('user.id')
    ;

    if ($search = $request->query('search')) {
      $query->search($search);
    }

    $users = $query->latest()->paginate(1000);

    return view("admin.users.list", [
      'title'  => __('Пользователи'),
      'search' => $search,
      'users'  => $users,
    ]);

  }

  //user's accounts
  public function accounts($userId) {
    return "show users accounts";
    /** @var $user Model_User */
    $user = ORM::factory("User", $this->request->param('id'));
    if (!$user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    $view = View::factory("admin/users/accounts", ['user' => $user]);
    $this->template->content = $view;
  }

  //edit user info
  public function action_item() {

    /** @var Model_User $user */
    $user = ORM::factory("User", $this->request->param('id'));

    if (!$user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list"); //todo route
    }

    $errors = [];
    if ($this->request->method() == Request::POST) {

      $validation = Validation::factory($_POST)
        ->rules('firstname', [
          ['not_empty'],
        ])
        ->rules('lastname', [
//          ['not_empty'],
        ])
        ->rules('username', [
          ['not_empty'],
          [[$user, 'unique'], ['username', ':value']],
        ])
        ->rules('email', [
//          ['not_empty'],
          ['email'],
          [[$user, 'unique'], ['email', ':value']],
        ])
        ->rules('tel', [
          [[$user, 'unique'], ['tel', ':value']],
        ])
        ->rules('skype', [
          [[$user, 'unique'], ['skype', ':value']],
        ])
        ->rules('twitter', [
          [[$user, 'unique'], ['twitter', ':value']],
        ])
        ->rules('instagram', [
          [[$user, 'unique'], ['instagram', ':value']],
        ]);

      if ($validation->check()) {
        $user->firstname = Arr::get($_POST, 'firstname');
        $user->lastname = Arr::get($_POST, 'lastname');
        $user->patronymic = Arr::get($_POST, 'patronymic');
        $user->username = Arr::get($_POST, 'username');
        $user->email = Arr::get($_POST, 'email');
        //todo validate birth trio: day, month, year
        $user->birth_day = ($birth_day = Arr::get($_POST, 'birth_day')) ? $birth_day : null;
        $user->birth_month = ($birth_month = Arr::get($_POST, 'birth_month')) ? $birth_month : null;
        $user->birth_year = ($birth_year = Arr::get($_POST, 'birth_year')) ? $birth_year : null;
        $user->sex = Arr::get($_POST, 'sex');
        $user->country_id = ($country_id = Arr::get($_POST, 'country')) ? $country_id : null;
        $user->city_id = ($city_id = Arr::get($_POST, 'city')) ? $city_id : null;
        $user->tel = ($tel = Arr::get($_POST, 'tel')) ? $tel : null;
        $user->skype = ($skype = Arr::get($_POST, 'skype')) ? $skype : null;
        $user->twitter = ($twitter = Arr::get($_POST, 'twitter')) ? $twitter : null;
        $user->instagram = ($instagram = Arr::get($_POST, 'instagram')) ? $instagram : null;
        $user->flag = (boolean)Arr::get($_POST, 'flag');
        $user->save();

        $this->add_image($user, 'avatar');

        Session::instance()->set('message_success', __('Пользователь успешно сохранен'));
        HTTP::redirect("/admin/users/item/{$user->id}");
      } else {
        $errors = $validation->errors('models/user');
      }
    }

    $countries = ORM::factory('Country')->order_by('title')->find_all();
    $cities = $user->country->cities->order_by('title')->find_all();

    $view = View::factory("admin/users/item", [
      'errors'    => $errors,
      'user'      => $user,
      'countries' => $countries,
      'cities'    => $cities,
    ]);

    $this->title = $user->fullname;
    $this->template->content = $view;
  }

  public function action_subscribe() {

    if ($this->request->method() != Request::POST) throw new HTTP_Exception_404;

    /** @var Model_User $user */
    $user = ORM::factory("User", $this->request->param('id'));
    if (!$user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect(URL::get_redirect_url());
    }

    $type = $this->request->post('type');

    if ($type == 'company') {
      $company_title = trim(Arr::get($_POST, 'company'));
      /** @var Model_Company $company */
      $company = ORM::factory('Company', ['title' => $company_title]);
      if (!$company->loaded()) {
        Session::instance()->set('message_error', __('Компания не найдена'));
        HTTP::redirect(URL::get_redirect_url());
      }

      if ($user->is_company_subscribed($company)) {
        Session::instance()->set('message_warning', __('Пользователь уже подписан на компанию :company', [':company' => $company->title]));
        HTTP::redirect(URL::get_redirect_url());
      }

      /** @var Model_Subscription $subscription */
      $subscription = ORM::factory('Subscription');
      $subscription->type = 'company';
      $subscription->user = $user;
      $subscription->company = $company;
      $subscription->save();

      $company->recount_followers();
      Session::instance()->set('message_success', __('Пользователь успешно подписан на компанию :company', [':company' => $company->title]));
    } elseif ($type == 'user') {

      $to_user_fullname = trim($this->request->post('user'));
      /** @var Model_User $to_user */
      $to_user = ORM::factory('User')->where(DB::expr("CONCAT(user.firstname, ' ', user.lastname)"), '=', $to_user_fullname)->find();
      if (!$to_user->loaded()) {
        Session::instance()->set('message_error', __('Пользователь не найден'));
        HTTP::redirect(URL::get_redirect_url());
      }

      if ($user->is_user_subscribed($to_user)) {
        Session::instance()->set('message_warning', __('Пользователь уже подписан на пользователя :to_user', [':to_user' => $to_user->fullname]));
        HTTP::redirect(URL::get_redirect_url());
      }

      /** @var Model_Subscription $subscription */
      $subscription = ORM::factory('Subscription');
      $subscription->type = 'user';
      $subscription->user = $user;
      $subscription->to_user = $to_user;
      $subscription->save();

      $to_user->recount_followers();
      Session::instance()->set('message_success', __('Пользователь успешно подписан на пользователя :to_user', [':to_user' => $to_user->fullname]));

    }


    HTTP::redirect(URL::get_redirect_url());

  }

  public function action_reviews() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    $reviews = $this->user->reviews->order_by('added', 'DESC')->find_all();

    $title = __('Отзывы :of_fullname', [':of_fullname' => $this->user->of_fullname]);

    $view = View::factory("admin/users/reviews", [
      'title'   => $title,
      'user'    => $this->user,
      'reviews' => $reviews,
      'count'   => count($reviews),
    ]);


    $this->title = $title;
    $this->template->content = $view;
  }

  public function action_interviews() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    $interviews = $this->user->interviews
      ->join('interview_questions', 'LEFT')->on('interview_questions.interview_id', '=', 'interview.id')
      ->group_by('interview.id')
      ->select([DB::expr('COUNT(DISTINCT interview_questions.id)'), 'questions_count'])
      ->order_by('added', 'DESC')->find_all();

    $count = count($interviews);
    $title = __('Собеседования :of_fullname', [':of_fullname' => $this->user->of_fullname]);
    $view = View::factory("admin/users/interviews", [
      'user'       => $this->user,
      'interviews' => $interviews,
      'title'      => $title,
      'count'      => $count,
    ]);

    $this->title = $title;
    $this->template->content = $view;
  }

  public function action_salaries() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    $salaries = $this->user->salaries->order_by('added', 'DESC')->find_all();

    $title = __('Зарплаты :of_fullname', [':of_fullname' => $this->user->of_fullname]);
    $count = count($salaries);
    $view = View::factory("admin/users/salaries", [
      'title'    => $title,
      'user'     => $this->user,
      'salaries' => $salaries,
      'count'    => $count,
    ]);

    $this->title = $title;
    $this->template->content = $view;
  }

  public function action_images() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    $images = $this->user->images
      ->where('image.parent_id', 'IS', null)
      ->order_by('added', 'DESC')
      ->find_all();

    $title = __('Фотографии :of_fullname', [':of_fullname' => $this->user->of_fullname]);
    $count = count($images);
    $view = View::factory("admin/users/images", [
      'title'  => $title,
      'user'   => $this->user,
      'images' => $images,
      'count'  => $count,
    ]);

    $this->title = $title;
    $this->template->content = $view;
  }

  public function action_companies() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    //компании, которыми управляет пользователь
    $companies_managed = $this->user->companies
      ->select('users_companies.job_title')
      ->order_by('company.added', 'DESC')
      ->find_all();

    //компании, которые добавил пользователь
    $companies_created = ORM::factory('Company')
      ->where('added_user_id', '=', $this->user->id)
      ->order_by('company.added', 'DESC')
      ->find_all();

    $title = __('Компании :of_fullname', [':of_fullname' => $this->user->of_fullname]);
    $view = View::factory("admin/users/companies", [
      'title'             => $title,
      'user'              => $this->user,
      'companies_managed' => $companies_managed,
      'companies_created' => $companies_created,
    ]);

    $this->title = $title;
    $this->template->content = $view;
  }

  public function action_subscriptions() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    //общее кол-во подписок
    $total = ORM::factory('Subscription')
      ->where('user_id', '=', $this->user->id)
      ->count_all();

    //компании, на которые подписан пользователь
    $company_subscriptions = ORM::factory('Subscription')
      ->where('user_id', '=', $this->user->id)
      ->and_where('type', '=', 'company')
      ->order_by('subscription.added', 'DESC')
      ->find_all();

    //пользователи, на которых подписан пользователь
    $user_subscriptions = ORM::factory('Subscription')
      ->where('user_id', '=', $this->user->id)
      ->and_where('type', '=', 'user')
      ->order_by('subscription.added', 'DESC')
      ->find_all();

    $title = __('Подписки :of_fullname', [':of_fullname' => $this->user->of_fullname]);
    $view = View::factory("admin/users/subscriptions", [
      'total'                 => $total,
      'title'                 => $title,
      'user'                  => $this->user,
      'company_subscriptions' => $company_subscriptions,
      'user_subscriptions'    => $user_subscriptions,
    ]);

    $this->title = $title;
    $this->template->content = $view;
  }

  //user's job experiences
  public function action_experiences() {

    if (!$this->user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect("/admin/users/list");
    }

    $query = $this->user->experiences;


    $count = $query->reset(false)->count_all();
    $experiences = $query->find_all();

    $title = __('Опыт работы :of_fullname', [':of_fullname' => $this->user->of_fullname]);
    $view = View::factory("admin/users/experiences", [
      'title'       => $title,
      'count'       => $count,
      'experiences' => $experiences,
      'user'        => $this->user,
    ]);

    $this->title = $title;
    $this->template->content = $view;
  }

  public function action_vkInfo() {
    $this->auto_render = false;
    $vk_user_id = $this->request->param('id');
    $fields = [
      'about',
      'quotes',
      'relation',
      'nickname',
      'occupation',
      'personal',
      'career',
      'city',
      'country',
      'domain',
      'education',
      'schools',
      'site',
      'status',
      'universities',
      'verified',

      //падежи
      'first_name_nom',
      'first_name_gen',
      'first_name_dat',
      'first_name_acc',
      'first_name_ins',
      'first_name_abl',

      'last_name_nom',
      'last_name_gen',
      'last_name_dat',
      'last_name_acc',
      'last_name_ins',
      'last_name_abl',

      'home_town',
      'interests',
    ];
    $json = VK::instance()->get_user_info($vk_user_id, $fields, null, true);
    $this->response->headers('Content-Type', 'application/json; charset=utf-8')->body($json);
  }

  public function action_vkImport() {
    $this->auto_render = false;
    $this->response->headers('Content-Type', 'text/plain; charset=utf-8');

    $user_id = $this->request->post('id');

    /** @var Model_User $user */
    $user = ORM::factory('User', $user_id);

    if (!$user->loaded()) {
      Session::instance()->set('message_error', __('Пользователь не найден'));
      HTTP::redirect(URL::get_redirect_url('/admin/user/list'));
    }

    if (!$user->vk_account->loaded()) {
      Session::instance()->set('message_error', __('Аккаунт ВКонтакте не найден'));
      HTTP::redirect(URL::get_redirect_url('/admin/user/list'));
    }

    $user->import_from_vk();
    Session::instance()->set('message_success', __('Импорт успешно выполнен'));
    HTTP::redirect(URL::get_redirect_url("/admin/user/accounts/{$user->id}"));

  }

  public function delete(Request $request) {
    $user = User::find($request->input('id'));
    if ($user) $user->delete();
  }

}