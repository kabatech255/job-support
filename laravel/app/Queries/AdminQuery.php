<?php

namespace App\Queries;

use App\Contracts\Queries\AdminQueryInterface;
use App\Models\Admin;
use App\Queries\Abstracts\EloquentQuery;

class AdminQuery extends EloquentQuery implements AdminQueryInterface
{
  public function __construct(Admin $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
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
      return $collection->map(function ($admin) {
        return [
          'email' => $admin->email,
          'email_verified_at' => !!$admin->email_verified_at
        ];
      })->all();
    }
    return $collection->all();
  }
}
