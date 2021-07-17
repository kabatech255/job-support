<?php

namespace App\Queries;

use App\Contracts\Queries\BlogQueryInterface;
use App\Models\Blog;
use App\Queries\Abstracts\EloquentQuery;

class BlogQuery extends EloquentQuery implements BlogQueryInterface
{
  public function __construct(Blog $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
