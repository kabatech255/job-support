<?php

namespace App\Queries;

use App\Contracts\Queries\UserQueryInterface;
use App\Models\User;
use App\Queries\Abstracts\EloquentQuery;

class UserQuery extends EloquentQuery implements UserQueryInterface
{
  public function __construct(User $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([
      'notifyVadations' => [
        'action_type_id',
        'is_valid',
        'user_id',
      ]
    ]);
  }

  /**
   * @param int $actionTypeId
   * @return array
   */
  public function getNotifiableOf(int $actionTypeId): array
  {
    $query = $this->builder();
    $query = $query->whereHas('notifyValidations', function ($q) use ($actionTypeId) {
      $q->where('action_type_id', $actionTypeId)->where('is_valid', 1);
    });
    return $query->get()->all();
  }
}
