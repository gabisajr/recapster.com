<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

  public function __construct() {
    $this->middleware('guest:admin', ['except' => 'logout']);
  }

  public function showLoginForm() {
    return view('admin.auth.login');
  }

  public function login(Request $request) {

    $this->validate($request, [
      'email'    => 'required|email',
      'password' => 'required|min:6',
    ], [
      'email.required'    => 'Введите E-mail',
      'email.email'       => 'Введите корректный E-mail',
      'password.required' => 'Введите пароль',
      'password.min'      => 'Слишком короткий пароль',
    ]);

    $credentials = [
      'email'    => $request->email,
      'password' => $request->password,
    ];

    $remember = $request->remember;

    $res = Auth::guard('admin')->attempt($credentials, $remember);

    if ($res) {
      return redirect()->intended(route('admin'));
    }

    return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
      'email' => "Не верный E-mail или пароль",
    ]);
  }

  public function logout() {

    Auth::guard('admin')->logout();

    return redirect(route('admin'));
  }

}
