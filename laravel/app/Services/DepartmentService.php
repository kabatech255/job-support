<?php

namespace App\Services;

use App\Contracts\Queries\DepartmentQueryInterface as Query;
use App\Contracts\Repositories\DepartmentRepositoryInterface as Repository;

class DepartmentService extends MasterService
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
