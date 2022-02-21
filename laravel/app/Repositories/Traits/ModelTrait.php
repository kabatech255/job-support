<?php

namespace App\Repositories\Traits;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

  /**
   * @param Authenticatable $createdBy
   * @return integer
   */
  public function idByInstance(Authenticatable $createdBy): int
  {
    return $createdBy instanceof Admin ? $createdBy->bUser->id : $createdBy->id;
  }
}
