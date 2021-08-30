<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $prefix = 'App\\';
    $dirName = 'Repositories';
    $path = app_path($dirName);
    $files = File::files($path);
    foreach ($files as $file) {
      $abstract = $prefix . 'Contracts\\' . "{$dirName}\\" . str_replace('.php', '', $file->getFileName()) . 'Interface';
      $concrete = "{$prefix}{$dirName}\\" . str_replace('.php', '', $file->getFileName());
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
