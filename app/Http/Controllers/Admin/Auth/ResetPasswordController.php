<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller {
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;

  public function showResetForm(Request $request, $token = null) {
    return view('admin.auth.passwords.reset')->with(
      ['token' => $token, 'email' => $request->email]
    );
  }

  protected function validationErrorMessages() {
    return [
      'email.required'     => 'Введите ваш e-mail',
      'password.min'       => 'Слишком короткий пароль',
      'password.confirmed' => 'Пароли не совпадают',
      'password.required'  => 'Введите новый пароль',
    ];
  }

  protected $redirectTo = '/admin';

  /**
   * Create a new controller instance.
   */
  public function __construct() {
    $this->middleware('guest:admin');
  }

  public function broker() {
    return Password::broker("admins");
  }

  protected function guard() {
    return Auth::guard("admin");
  }

}
