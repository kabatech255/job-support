<?php

namespace App\Repositories;

use App\Contracts\Repositories\TodoRepositoryInterface;
use App\Models\Todo;
use App\Repositories\Abstracts\EloquentRepository;

class TodoRepository extends EloquentRepository implements TodoRepositoryInterface
{
  public function __construct(Todo $model)
  {
    $this->setModel($model);
  }
}
