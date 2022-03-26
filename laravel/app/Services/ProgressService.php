<?php

namespace App\Services;

use App\Contracts\Queries\ProgressQueryInterface as Query;
use App\Contracts\Repositories\ProgressRepositoryInterface as Repository;

class ProgressService extends MasterService
{
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    // else repository...
  }

  /**
   * @param array $params
   * @return array
   */
  public function all(array $params, array $relation = ['createdBy']): array
  {
    $progress = parent::all($params, $relation);
    return collect($progress)->map(function ($p) {
      // Progressモデルで$appendsに加えると502
      $p->task_count = $p->task_count;
      return $p;
    })->all();
  }
}
