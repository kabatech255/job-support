<?php

namespace App\Queries;

use App\Contracts\Queries\ActivityQueryInterface;
use App\Models\Activity;
use App\Queries\Abstracts\EloquentQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

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
  public function maxRecordsForUser(int $limit, array $params)
  {
    $query = parent::search($params);
    $query->where('user_id', $params['user_id'])->whereIn('action_type_id', $params['action_type_ids'])->orderBy('id', 'desc')->limit($limit);
    return $query->get()->all();
  }

  public function searchByActionTypeIds($query, array $actionTypeIds): Builder
  {
    return $query->whereIn('action_type_id', $actionTypeIds);
  }

  /**
   * @param int $createdBy
   * @param string $authenticatable
   * @param array $relation
   * @return Collection
   */
  public function findByCreatedUserAndActionType(array $params, $relation = ['createdBy'])
  {
    $year = Carbon::parse('-1 years');
    $query = $this->builder()->with($relation);

    $query = $query
      ->where('created_by', $params['created_by'])
      ->where('created_at', '>', $year);

    $query = $this->searchByActionTypeIds($query, $params['action_type_ids']);
    return $query
      ->orderBy('id', 'desc')
      ->get();
  }
}
