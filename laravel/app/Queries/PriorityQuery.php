<?php

namespace App\Queries;

use App\Contracts\Queries\PriorityQueryInterface;
use App\Models\Priority;
use App\Queries\Abstracts\EloquentQuery;

class PriorityQuery extends EloquentQuery implements PriorityQueryInterface
{
  public function __construct(Priority $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
