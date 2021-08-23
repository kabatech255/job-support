<?php

namespace App\Repositories;

use App\Contracts\Repositories\FacialExpressionRepositoryInterface;
use App\Models\FacialExpression;
use App\Repositories\Abstracts\EloquentRepository;

class FacialExpressionRepository extends EloquentRepository implements FacialExpressionRepositoryInterface
{
  public function __construct(FacialExpression $model)
  {
    $this->setModel($model);
  }
}
