<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use App\Username;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller {
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data) {
    return Validator::make($data, [
      'email'    => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
    ], [
      'email.required'     => 'Введите ваш Email',
      'email.unique'       => 'Этот Email уже зарегистрирован',
      'password.required'  => 'Придумайте пароль',
      'password.min'       => 'Пароль должен быть не менее :min символов',
      'password.confirmed' => 'Повторите пароль для надежности',
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array $data
   * @return \App\Model\User
   */
  protected function create(array $data) {

    /** @var User $user */
    $user = User::create([
      'email'    => $data['email'],
      'password' => bcrypt($data['password']),
    ]);

    //generate username for new user
    Username::generateForUser($user);


    return $user;
  }

  public function showRegistrationForm(Request $request) {

    $socialInfo = $this->getSocialInfo();
    $email = array_get($socialInfo, 'email');
    $employer = $request->query('employer');

    $title = __('Регистрация') . " — " . config('app.name');

    return view('auth.signup', [
      'socialInfo' => $socialInfo,
      'email'      => $email,
      'employer'   => $employer,
      'title'      => $title,
    ]);
  }

  private function getSocialInfo() {
    $socialInfo = [];

    if ($vkUserInfo = session('signup_vk_user_info')) {
      //авторизационные данные ВК
      $socialInfo['service'] = 'vk';
      if (isset($vkUserInfo->email)) $socialInfo['email'] = $vkUserInfo->email;
      if (isset($vkUserInfo->first_name)) $socialInfo['firstname'] = $vkUserInfo->first_name;
      if (isset($vkUserInfo->last_name)) $socialInfo['lastname'] = $vkUserInfo->last_name;
      if (isset($vkUserInfo->photo_100)) $socialInfo['photo_preview'] = $vkUserInfo->photo_100;

    } elseif ($fbUserInfo = session('signup_fb_user_info')) {

      //авторизационые данные Facebook
      $socialInfo['service'] = 'facebook';
      if (isset($fbUserInfo->email)) $socialInfo['email'] = $fbUserInfo->email;
      if (isset($fbUserInfo->first_name)) $socialInfo['firstname'] = $fbUserInfo->first_name;
      if (isset($fbUserInfo->last_name)) $socialInfo['lastname'] = $fbUserInfo->last_name;
      if (isset($fbUserInfo->picture)) $socialInfo['photo_preview'] = $fbUserInfo->picture->data->url;

    }

    return $socialInfo;
  }

}
