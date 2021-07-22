<?php

namespace App\Services;

use App\Contracts\Queries\MeetingPlaceQueryInterface as Query;
use App\Contracts\Repositories\MeetingPlaceRepositoryInterface as Repository;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class MeetingPlaceService extends Service
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
