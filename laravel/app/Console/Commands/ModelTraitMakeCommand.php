<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;

class ModelTraitMakeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'make:modeltrait';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Model Trait';
  protected $type = 'ModelTrait';

  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Repositories\Traits';
  }
  /**
   * @return string
   */
  protected function getStub()
  {
    return __DIR__ . '/stubs/model_trait.stub';
  }
  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return [
      ['name', InputArgument::OPTIONAL, 'The name of the class'],
    ];
  }

  /**
   * @param string $name
   * @return string|void
   */
  protected function getNameInput()
  {
    return 'ModelTrait';
  }
}
