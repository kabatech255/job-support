<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;

class QueryInterfaceCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'make:queryInterface';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Query Interface';
  protected $type = 'QueryInterface';

  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Contracts\Queries';
  }
  /**
   * @return string
   */
  protected function getStub()
  {
    if ($this->getNameInput() === 'QueryInterface') {
      return __DIR__ . '/stubs/base_query_interface.stub';
    }
    return __DIR__ . '/stubs/query_interface.stub';
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
      'DummyParentInterface' => 'QueryInterface',
    ];

    return str_replace(
      array_keys($replace),
      array_values($replace),
      parent::buildClass($name)
    );
  }
}
