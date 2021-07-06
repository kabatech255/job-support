<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogTagRepositoryInterface;
use App\Models\BlogTag;
use App\Repositories\Abstracts\EloquentRepository;

class BlogTagRepository extends EloquentRepository implements BlogTagRepositoryInterface
{
  public function __construct(BlogTag $model)
  {
    $this->setModel($model);
  }
}
