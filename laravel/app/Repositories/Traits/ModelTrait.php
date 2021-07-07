<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

trait ModelTrait
{
  /**
   * @var Model
   */
  private $model;

  /**
   * @param Model $model
   * @return $this
   */
  public function setModel(Model $model)
  {
    $this->model = $model;
    return $this;
  }

  /**
   * @return Model
   */
  public function model(): Model
  {
    return $this->model;
  }
}
