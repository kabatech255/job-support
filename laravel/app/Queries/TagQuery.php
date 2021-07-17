<?php

namespace App\Queries;

use App\Contracts\Queries\TagQueryInterface;
use App\Models\Tag;
use App\Queries\Abstracts\EloquentQuery;

class TagQuery extends EloquentQuery implements TagQueryInterface
{
  public function __construct(Tag $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
