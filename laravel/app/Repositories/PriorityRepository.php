<?php

namespace App\Repositories;

use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Models\Priority;
use App\Repositories\Abstracts\EloquentRepository;

class PriorityRepository extends EloquentRepository implements PriorityRepositoryInterface
{
  public function __construct(Priority $model)
  {
    $this->setModel($model);
  }
}
