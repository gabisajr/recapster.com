<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Start extends Controller_User_Base {

  public function before() {
    parent::before();
    $this->template->header_banner = null;
    $this->template->tip = null;
  }

  public function action_index() {

    if (!Auth::instance()->logged_in()) HTTP::redirect('/');

    $user = $this->curr_user;

    //уже есть имя и фамилия
    if ($user->firstname && $user->lastname) HTTP::redirect($user->profile_url);

    $firstname = Arr::get($_POST, 'firstname', $user->firstname);
    $lastname = Arr::get($_POST, 'lastname', $user->lastname);
    $avatar = Arr::get($_POST, 'avatar', ($user->avatar->loaded() ? $user->avatar->path : null));

    $errors = [];

    if ($this->request->method() == Request::POST) {

      $validation = Validation::factory($_POST)
        ->rules('firstname', [
          ['not_empty'],
        ])
        ->rules('lastname', [
          ['not_empty'],
        ]);

      if ($validation->check()) {

        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->save();
        $user->save_upload_avatar();
        $user->set_default_status();
        Session::instance()->set('show_user_welcome_modal', true);
        HTTP::redirect($user->profile_url);

      } else {
        $errors = $validation->errors('models/user');
      }

    }

    $view = View::factory('user/page/start', [
      'errors'    => $errors,
      'firstname' => $firstname,
      'lastname'  => $lastname,
      'avatar'    => $avatar,
    ]);

    $this->template->title = __('Начало работы');
    $this->template->content = $view;
    $this->main_js = '/js/user/start.js';
  }

}