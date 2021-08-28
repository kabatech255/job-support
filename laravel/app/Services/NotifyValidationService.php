<?php

namespace App\Services;

use App\Contracts\Queries\NotifyValidationQueryInterface as Query;
use App\Contracts\Repositories\NotifyValidationRepositoryInterface as Repository;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class NotifyValidationService extends Service
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
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
    // else repository...
  }
}
