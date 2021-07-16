<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Facades\Artisan;

class QueryMakeCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
//  protected $signature = 'command:name';
  protected $name = 'make:query';
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create a new Query class';
  protected $type = 'Query';

  public function handle()
  {
    Artisan::call('make:queryInterface', ['name' => $this->getNameInput() . 'Interface']);
    $this->info($this->getNameInput().' Interface created successfully.');
    parent::handle();
  }

  /**
   * Generator側がクラス生成に使うnamespaceを決めてあげる
   * @param string $rootNamespace
   * @return string
   */
  protected function getDefaultNamespace($rootNamespace)
  {
    return $rootNamespace . '\Queries';
  }


  /**
   * 生成に使うスタブファイルを取得する
   * @return string
   */
  protected function getStub()
  {
    return __DIR__.'/stubs/query.stub';
  }

  /**
   * 指定された名前でクラスを構築する
   *
   * @param  string  $name
   * @return string
   */
  protected function buildClass($name)
  {
    $modelName = str_replace($this->type, '', $this->getNameInput());
    // 引数やオプションなどを使い'置換前'=>'置換後'のような配列を作る
    $replace = [
      'DummyModel' => $modelName,
    ];

    return str_replace(
      array_keys($replace),
      array_values($replace),
      parent::buildClass($name)
    );
  }
}
