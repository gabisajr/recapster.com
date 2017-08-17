<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use View;

class LoadCurrUser {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   * @return mixed
   */
  public function handle($request, Closure $next) {

    $currUser = Auth::getUser();
    View::share("currUser", $currUser);

    return $next($request);
  }
}
