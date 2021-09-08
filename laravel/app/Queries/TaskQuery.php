<?php

namespace App\Queries;

use App\Contracts\Queries\TaskQueryInterface;
use App\Queries\Abstracts\EloquentQuery;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class TaskQuery extends EloquentQuery implements TaskQueryInterface
{
  public function __construct(Task $model)
  {
    $this->setBuilder($model);
    $this->setColumns(['body', 'created_by', 'owner_id', 'priority_id', 'progress_id']);
    $this->setRelationTargets([
      'priority' => [
        'id',
        'name',
      ],
      'progress' => [
        'id',
        'name',
      ],
    ]);
  }

  /**
   * @param array $params
   * @param array $relation
   * @return Builder
   */
  public function search(array $params, array $relation = []): Builder
  {
    $query = parent::search($params, $relation);
    if (!empty($params['status'] ?? '')) {
      $query = $this->filterByStatus($query, $params['status']);
    }
    return $query;
  }

  private function filterByStatus($query, $param)
  {
    $query->where(function ($query) use ($param) {
      $statuses = explode(',', $param);
      foreach ($statuses as $status) {
        if ($status === 'warning') {
          $today = Carbon::now();
          $warning = Carbon::today()->addDays(Task::WARNING_LIMIT_DAY + Task::INCLUDES_JUST_DATE)->format('Y-m-d H:i:s');
          $query->orWhereBetween('time_limit', [$today, $warning]);
        }
        if ($status === 'over') {
          $query->orWhere('time_limit', '<', Carbon::now()->format('Y-m-d H:i:s'));
        }
      }
    });
    return $query;
  }
}
