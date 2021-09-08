<?php

namespace App\Queries;

use App\Contracts\Queries\ActivityQueryInterface;
use App\Models\Activity;
use App\Queries\Abstracts\EloquentQuery;

class ActivityQuery extends EloquentQuery implements ActivityQueryInterface
{
  public function __construct(Activity $model)
  {
    $this->setBuilder($model);
    $this->setColumns([
      'user_id',
    ]);
    $this->setRelationTargets([]);
  }

  /**
   * @param int $limit
   * @param array $params
   * @param array|null $relation
   * @return array
   */
  public function limitOfUser(int $limit, array $params)
  {
    $query = parent::search($params);
    $query->where('user_id', $params['user_id'])->orderBy('id', 'desc')->limit($limit);
    return $query->get()->all();
  }
}
