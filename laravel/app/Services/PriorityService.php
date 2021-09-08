<?php

namespace App\Services;

use App\Contracts\Queries\PriorityQueryInterface as Query;
use App\Contracts\Repositories\PriorityRepositoryInterface as Repository;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class PriorityService extends Service
{
  use WithRepositoryTrait;

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
  }

  /**
   *
   */
  public function all()
  {
    return $this->repository()->all();
  }
}
