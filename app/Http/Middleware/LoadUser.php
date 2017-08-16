<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class LoadUser {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   * @return mixed
   */
  public function handle($request, Closure $next) {

    $username = $request->route('username');
    $user = User::where('username', '=', $username)->firstOrFail();
    $request->user = $user;

    return $next($request);
  }
}
