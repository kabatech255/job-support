<?php

namespace App\Repositories;

use App\Contracts\Repositories\ActivityRepositoryInterface;
use App\Models\Activity;
use App\Repositories\Abstracts\EloquentRepository;

class ActivityRepository extends EloquentRepository implements ActivityRepositoryInterface
{
  public function __construct(Activity $model)
  {
    $this->setModel($model);
  }
}
