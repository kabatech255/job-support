<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Queries\MeetingRecordQueryInterface;
use App\Queries\MeetingRecordQuery;

class QueryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(MeetingRecordQueryInterface::class, MeetingRecordQuery::class);
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
