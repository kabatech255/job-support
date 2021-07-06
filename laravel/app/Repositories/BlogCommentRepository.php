<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogCommentRepositoryInterface;
use App\Models\BlogComment;
use App\Repositories\Abstracts\EloquentRepository;

class BlogCommentRepository extends EloquentRepository implements BlogCommentRepositoryInterface
{
  public function __construct(BlogComment $model)
  {
    $this->setModel($model);
  }
}
