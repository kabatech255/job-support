<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class QueryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $prefix = 'App\\';
    $path = app_path('Queries');
    $files = File::files($path);
    foreach($files as $file) {
      $abstract = $prefix . 'Contracts\Queries\\' . str_replace('.php', '', $file->getFileName()) . 'Interface';
      $concrete = $prefix . 'Queries\\' . str_replace('.php', '', $file->getFileName());
      $this->app->bind($abstract, $concrete);
    }
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
