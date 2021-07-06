<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;

class RepositoryInterfaceCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'make:repositoryInterface';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Repository Interface';
  protected $type = 'RepositoryInterface';

  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Contracts\Repositories';
  }
  /**
   * @return string
   */
  protected function getStub()
  {
    if ($this->getNameInput() === 'RepositoryInterface') {
      return __DIR__ . '/stubs/base_repository_interface.stub';
    }
    return __DIR__ . '/stubs/repository_interface.stub';
  }

  /**
   * 指定された名前でクラスを構築する
   *
   * @param  string  $name
   * @return string
   */
  protected function buildClass($name)
  {
    // 引数やオプションなどを使い'置換前'=>'置換後'のような配列を作る
    $replace = [
      'DummyParentInterface' => 'RepositoryInterface',
    ];

    return str_replace(
      array_keys($replace),
      array_values($replace),
      parent::buildClass($name)
    );
  }
}
