<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RepositoryInitializeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'initialize:repository';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Kit and Make Repositories from All Models';

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
    Artisan::call('kit:repository');
    $this->info('RepositoryInterface created successfully.');
    $this->info('ModelTrait created successfully.');
    $this->info('CommonAbstructRepository created successfully.');
    $this->info('EloquentRepository created successfully.');
    Artisan::call('send:modelsToRepositories');
    $this->info('Models were sent to Repositories successfully.');
  }
}
