<?php

namespace App\Services;

use App\Contracts\Queries\ReportCategoryQueryInterface as Query;
use App\Contracts\Repositories\ReportCategoryRepositoryInterface as Repository;
use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Support\Facades\Auth;

class ReportCategoryService extends Service
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
  }

  /**
   * @param array $params
   * @return array
   */
  public function index(array $params = [])
  {
    return $this->query()->all($params);
  }
}
