<?php

namespace App\Repositories;

use App\Contracts\Repositories\TagRepositoryInterface;
use App\Models\Tag;
use App\Repositories\Abstracts\EloquentRepository;

class TagRepository extends EloquentRepository implements TagRepositoryInterface
{
  public function __construct(Tag $model)
  {
    $this->setModel($model);
  }
}
