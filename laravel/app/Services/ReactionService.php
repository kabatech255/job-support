<?php

namespace App\Services;

use App\Contracts\Queries\ReactionQueryInterface as Query;
use App\Contracts\Repositories\ReactionRepositoryInterface as Repository;
use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Support\Facades\Auth;

class ReactionService extends Service
{
  use RepositoryUsingSupport;

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
