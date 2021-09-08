<?php

namespace App\Services;

use App\Contracts\Queries\ProgressQueryInterface as Query;
use App\Contracts\Repositories\ProgressRepositoryInterface as Repository;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class ProgressService extends Service
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
    // else repository...
  }

  public function all()
  {
    return $this->repository()->all();
  }
}
