<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogRepositoryInterface;
use App\Models\Blog;
use App\Repositories\Abstracts\EloquentRepository;

class BlogRepository extends EloquentRepository implements BlogRepositoryInterface
{
  public function __construct(Blog $model)
  {
    $this->setModel($model);
  }
}
