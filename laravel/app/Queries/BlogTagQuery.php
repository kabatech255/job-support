<?php

namespace App\Queries;

use App\Contracts\Queries\BlogTagQueryInterface;
use App\Models\BlogTag;
use App\Queries\Abstracts\EloquentQuery;

class BlogTagQuery extends EloquentQuery implements BlogTagQueryInterface
{
  public function __construct(BlogTag $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
