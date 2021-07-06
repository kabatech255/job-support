<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogImageRepositoryInterface;
use App\Models\BlogImage;
use App\Repositories\Abstracts\EloquentRepository;

class BlogImageRepository extends EloquentRepository implements BlogImageRepositoryInterface
{
  public function __construct(BlogImage $model)
  {
    $this->setModel($model);
  }
}
