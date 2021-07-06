<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Symfony\Component\Console\Input\InputArgument;

class EloquentRepositoryMakeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'make:eloqrepo';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Eloquent Repository';
  protected $type = 'EloquentRepository';

  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Repositories\Abstracts';
  }

  /**
   * @return string
   */
  protected function getStub()
  {
    return __DIR__ . '/stubs/eloquent_repository.stub';
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

  protected function buildClass($name)
  {
    $replace = [
      'DummyModelTrait' => str_replace('Abstracts', 'Traits', $this->traitNamespace()),
    ];

    return str_replace(
      array_keys($replace),
      array_values($replace),
      parent::buildClass($name)
    );
  }

  /**
   * @return array|string|string[]
   */
  protected function traitNamespace()
  {
    $traitNamespace = $this->getDefaultNamespace(trim($this->rootNamespace(), '\\')) . '\ModelTrait';
    return str_replace('Abstracts', 'Traits', $traitNamespace);
  }

  /**
   * @param string $name
   * @return string|void
   */
  protected function getNameInput()
  {
    return 'EloquentRepository';
  }
}
