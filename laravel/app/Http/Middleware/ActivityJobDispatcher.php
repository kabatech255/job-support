<?php

namespace App\Http\Middleware;

use App\Jobs\Supports\ActivityJobSupportTrait;
use App\Enums\Activity;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

use Closure;

class ActivityJobDispatcher
{
  use ActivityJobSupportTrait;
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $response = $next($request);
    $routeName = Route::currentRouteName();
    if (array_key_exists($routeName, Activity::ACTIVITY_JOBS) && $response->status() < 300) {
      $className = Activity::ACTIVITY_JOBS[$routeName];
      $model = $response->getOriginalContent();
      $className::dispatch($model, $this->actionTypeRepository, $this->activityRepository)->afterResponse();
    }

    return $response;
  }
}
