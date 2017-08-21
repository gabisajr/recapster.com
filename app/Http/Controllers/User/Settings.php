<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Settings extends Controller_Base {

  public function before() {
    parent::before();
    if (!Auth::instance()->logged_in()) HTTP::redirect('/signin');
  }

  //настройки поиска
  public function action_search() {

    $user = $this->curr_user;
    $preferences = $user->job_preferences;


    if ($this->request->method() == Request::POST) {

      $preferences->position_title = Arr::get($_POST, 'position');
      $preferences->city_title = Arr::get($_POST, 'city');
      $preferences->salary = Arr::get($_POST, 'salary');
      $preferences->currency_code = Arr::get($_POST, 'currency');
      $preferences->ready_move = (boolean)Arr::get($_POST, 'ready_move');
      $preferences->notify_email = (boolean)Arr::get($_POST, 'notify_email');
      $preferences->notify_vk = (boolean)Arr::get($_POST, 'notify_vk');
      $preferences->user = $user;
      $preferences->save();

      //add employments
      $post_employments = Arr::get($_POST, 'employment', []);
      foreach ($post_employments as $employment) {
        if (!$preferences->has('employments', $employment)) {
          $preferences->add('employments', $employment);
        }
      }

      //remove employments
      /** @var Model_Employment $employment */
      foreach ($preferences->employments->find_all() as $employment) {
        if (!in_array($employment->alias, $post_employments)) {
          $preferences->remove('employments', $employment);
        }
      }

      $alert = new Alert_Success(__('Ваши предпочтения сохранены'));
      Session::instance()->set(Session::ALERT, $alert);
      HTTP::redirect('/settings/search');

    }

    //валюты
    $currencies_codes = ["KZT", "RUB", "USD", "EUR", "UAH"];
    $order_field = implode(', ', array_map(function ($code) {
      return "'{$code}'";
    }, $currencies_codes));

    $currencies = ORM::factory('Currency')
      ->where("code", "IN", $currencies_codes)
      ->order_by(DB::expr("field(code, $order_field)"))
      ->find_all();

    //формы занятости
    $employments = ORM::factory('Employment')->order_by('sort')->order_by('title')->find_all();

    $view = View::factory('settings/search', [
      'preferences' => $preferences,
      'currencies'  => $currencies,
      'employments' => $employments,
    ]);

    $layout = View::factory('settings/layout', [
      'user'             => $user,
      'content'          => $view,
      'menu_active'      => 'search',
      'is_settings_home' => $this->request->url() == '/settings',
    ]);

    $this->template->title = __('Настройки поиска');
    $this->template->content = $layout;
    $this->main_js = '/js/settings/search.js';
    $this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;
  }

  public function action_password() {
    $errors = Session::instance()->get_once('errors', []);
    $user = $this->curr_user;

    $view = View::factory('settings/password', [
      'errors' => $errors,
      'user'   => $user,
    ]);

    $layout = View::factory('settings/layout', [
      'user'        => $user,
      'content'     => $view,
      'menu_active' => 'password',
    ]);

    $this->template->title = __('Смена пароля');
    $this->template->content = $layout;
  }

}