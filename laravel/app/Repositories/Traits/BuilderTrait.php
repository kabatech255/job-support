<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

trait BuilderTrait
{
  private $builder;

  /**
   * @param Model $model
   * @return $this
   */
  public function setBuilder(Model $model)
  {
    $this->builder = $model;
    return $this;
  }

  public function builder()
  {
    return $this->builder->query();
  }
}
