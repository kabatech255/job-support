<?php

namespace App\Queries;

use App\Contracts\Queries\BlogLikeQueryInterface;
use App\Models\BlogLike;
use App\Queries\Abstracts\EloquentQuery;

class BlogLikeQuery extends EloquentQuery implements BlogLikeQueryInterface
{
  public function __construct(BlogLike $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
