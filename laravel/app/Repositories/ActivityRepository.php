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

  public function qualifiedStoreParams(array $params): array
  {
    return $params;
  }

  public function read($userId)
  {
    return $this->model()->where('user_id', $userId)->update([
      'is_read' => 1,
    ]);
  }
}
