<?php

namespace App\Queries;

use App\Contracts\Queries\LastReadQueryInterface;
use App\Models\LastRead;
use App\Queries\Abstracts\EloquentQuery;

class LastReadQuery extends EloquentQuery implements LastReadQueryInterface
{
  public function __construct(LastRead $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
