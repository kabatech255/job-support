<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Console\GeneratorCommand as Command;

class InitialApiCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'initial:api {name}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    Artisan::call('make:service', ['name' => $this->argument('name').'Service']);
    Artisan::call('make:request', ['name' => $this->argument('name').'/UpdateRequest']);
    Artisan::call('make:request', ['name' => $this->argument('name').'/StoreRequest']);
    Artisan::call('make:policy', [
      'name' => $this->argument('name').'Policy',
      '--model' => 'Models/'.$this->argument('name'),
    ]);
    Artisan::call('make:controller', [
      'name' => $this->argument('name').'Controller',
      '--resource' => true,
    ]);
    Artisan::call('make:test', ['name' => $this->argument('name').'Test']);

  }
}
