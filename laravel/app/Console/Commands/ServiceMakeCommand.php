<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Facades\Artisan;

class ServiceMakeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $name = 'make:service';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Service class';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $type = 'Service';

  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Services';
  }

  /**
   * 生成に使うスタブファイルを取得する
   * @return string
   */
  protected function getStub()
  {
    return __DIR__ . '/stubs/repository_using_service.stub';
  }

  /**
   * 指定された名前でクラスを構築する
   *
   * @param  string  $name
   * @return string
   */
  protected function buildClass($name)
  {
    $contractRepositoryName = $this->rootNamespace() . 'Contracts\Repositories\\';
    $contractRepositoryName .= str_replace($this->type, 'RepositoryInterface', $this->getNameInput());
    $contractQueryName = $this->rootNamespace() . 'Contracts\Queries\\';
    $contractQueryName .= str_replace($this->type, 'QueryInterface', $this->getNameInput());
    // 引数やオプションなどを使い'置換前'=>'置換後'のような配列を作る
    $replace = [
      'DummyContractRepository' => $contractRepositoryName,
      'DummyContractQuery' => $contractQueryName,
      'DummySupportNamespace' => $this->getDefaultNamespace(trim($this->rootNamespace(), '\\')) . '\Supports',
    ];

    return str_replace(
      array_keys($replace),
      array_values($replace),
      parent::buildClass($name)
    );
  }
}
