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

  /**
   * @param array $params
   * @param array|null $relation
   * @return array
   */
  public function all(array $params, ?array $relation = null): array
  {
    $collection = $this->search($params, $relation ?? $this->relation())->get();
    if (isset($params['slim']) && !!$params['slim']) {
      return $collection->map(function ($user) {
        return [
          'email' => $user->email,
          'email_verified_at' => !!$user->email_verified_at
        ];
      })->all();
    }
    return $collection->all();
  }
}
