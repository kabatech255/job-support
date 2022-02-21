<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class OrganizationFilter
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param string|null $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $belongs = 'createdBy')
  {
    if (Auth::check()) {
      $request->merge([$belongs . ':organization_id' => Auth::user()->organization_id,]);
    }
    return $next($request);
  }
}
