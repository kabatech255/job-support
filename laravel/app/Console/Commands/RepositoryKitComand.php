<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RepositoryKitComand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'kit:repository';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Kit Base Repository';

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
    Artisan::call('make:repositoryInterface', ['name' => 'RepositoryInterface']);
    $this->info('RepositoryInterface created successfully.');
    Artisan::call('make:modeltrait');
    $this->info('ModelTrait created successfully.');
    Artisan::call('make:commonrepo');
    $this->info('CommonAbstructRepository created successfully.');
    Artisan::call('make:eloqrepo');
    $this->info('EloquentRepository created successfully.');
  }
}
