<?php

namespace App\Services;

use App\Contracts\Queries\MeetingPlaceQueryInterface as Query;
use App\Contracts\Repositories\MeetingPlaceRepositoryInterface as Repository;

class MeetingPlaceService extends MasterService
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
}
