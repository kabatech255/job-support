<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogLikeRepositoryInterface;
use App\Models\BlogLike;
use App\Repositories\Abstracts\EloquentRepository;

class BlogLikeRepository extends EloquentRepository implements BlogLikeRepositoryInterface
{
  public function __construct(BlogLike $model)
  {
    $this->setModel($model);
  }
}
