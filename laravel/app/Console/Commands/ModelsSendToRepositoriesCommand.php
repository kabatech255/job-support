<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ModelsSendToRepositoriesCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'send:modelsToRepositories';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Make Repositories by ModelName';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    foreach($this->modelNames() as $modelName) {
      Artisan::call('make:repository', ['name' => $modelName . 'Repository']);
      $this->info($modelName.'Repositories created successfully.');
    }
  }

  /**
   * @return array
   */
  protected function modelNames()
  {
    $path = $this->laravel['path'].'/Models';
    $files = File::files($path);
    return collect($files)->map(function($f) {
      return str_replace('.php', '', $f->getFileName());
    })->all();
  }
}
