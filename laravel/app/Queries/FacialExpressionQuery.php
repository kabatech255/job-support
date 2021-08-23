<?php

namespace App\Queries;

use App\Contracts\Queries\FacialExpressionQueryInterface;
use App\Models\FacialExpression;
use App\Queries\Abstracts\EloquentQuery;

class FacialExpressionQuery extends EloquentQuery implements FacialExpressionQueryInterface
{
  public function __construct(FacialExpression $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
