<?php

namespace App\Http\Middleware;

use App\Model\Company;
use Closure;

class LoadCompany {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   * @return mixed
   */
  public function handle($request, Closure $next) {

    $alias = $request->route('company');
    $company = Company::where('alias', '=', $alias)->firstOrFail();
    $request->company = $company;

    return $next($request);
  }
}
