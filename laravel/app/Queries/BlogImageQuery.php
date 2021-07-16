<?php

namespace App\Queries;

use App\Contracts\Queries\BlogImageQueryInterface;
use App\Models\BlogImage;
use App\Queries\Abstracts\EloquentQuery;

class BlogImageQuery extends EloquentQuery implements BlogImageQueryInterface
{
  public function __construct(BlogImage $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
