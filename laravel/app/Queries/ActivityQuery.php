<?php

namespace App\Queries;

use App\Contracts\Queries\ActivityQueryInterface;
use App\Models\Activity;
use App\Queries\Abstracts\EloquentQuery;

class ActivityQuery extends EloquentQuery implements ActivityQueryInterface
{
  public function __construct(Activity $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
