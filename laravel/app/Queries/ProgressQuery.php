<?php

namespace App\Queries;

use App\Contracts\Queries\ProgressQueryInterface;
use App\Models\Progress;
use App\Queries\Abstracts\EloquentQuery;

class ProgressQuery extends EloquentQuery implements ProgressQueryInterface
{
  public function __construct(Progress $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
