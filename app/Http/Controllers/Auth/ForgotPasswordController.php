<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller {
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset emails and
  | includes a trait which assists in sending these notifications from
  | your application to your users. Feel free to explore this trait.
  |
  */

  use SendsPasswordResetEmails;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest');
  }

  public function showLinkRequestForm() {
    return view('auth.passwords.email', [
      'title'        => __('Восстановление пароля'),
      'main_js'      => 'restore',
      'useRecaptcha' => true,
    ]);
  }

  /**
   * Validate the email for the given request.
   *
   * @param \Illuminate\Http\Request $request
   * @return void
   */
  protected function validateEmail(Request $request) {
    $this->validate($request, [
      'email'                => 'required|email',
      'g-recaptcha-response' => 'required|recaptcha',
    ], [
      'email.required'                 => 'Введите Email, указанный при регистрации',
      'g-recaptcha-response.required'  => 'Поставьте флажок "Я не робот"',
      'g-recaptcha-response.recaptcha' => 'Неудачная попытка пройти защиту от роботов',
    ]);
  }

}
