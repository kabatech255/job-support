<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;

class CommonRepositoryMakeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'make:commonrepo';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Common Repository';
  protected $type = 'CommonAbstractRepository';

  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Repositories\Abstracts';
  }

  /**
   * @return string
   */
  protected function getStub()
  {
    return __DIR__ . '/stubs/abstruct_common_repository.stub';
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
    return 'CommonAbstractRepository';
  }
}
