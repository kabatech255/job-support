<?php

namespace App\Queries;

use App\Contracts\Queries\ActionTypeQueryInterface;
use App\Models\ActionType;
use App\Queries\Abstracts\EloquentQuery;

class ActionTypeQuery extends EloquentQuery implements ActionTypeQueryInterface
{
  public function __construct(ActionType $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
