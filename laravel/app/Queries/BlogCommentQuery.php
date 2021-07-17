<?php

namespace App\Queries;

use App\Contracts\Queries\BlogCommentQueryInterface;
use App\Models\BlogComment;
use App\Queries\Abstracts\EloquentQuery;

class BlogCommentQuery extends EloquentQuery implements BlogCommentQueryInterface
{
  public function __construct(BlogComment $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}
