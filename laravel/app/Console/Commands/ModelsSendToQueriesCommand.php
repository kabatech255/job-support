<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ModelsSendToQueriesCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'send:modelsToQueries';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Make Queries by ModelName';

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
      Artisan::call('make:query', ['name' => $modelName . 'Query']);
      $this->info($modelName.'Queries created successfully.');
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
