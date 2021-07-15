<?php

namespace App\Services;

use App\Contracts\Repositories\MeetingRecordRepositoryInterface as Repository;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Queries\MeetingRecordQueryInterface as Query;

class MeetingRecordService extends Service
{
  use WithRepositoryTrait;

  /**
   * UserService constructor.
   * @param Repository $repository
   */
  public function __construct(
    Repository $repository,
    Query $query
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @param int|null $perPage
   * @return mixed
   */
  public function paginate(array $params, ?array $relation = null, ?int $perPage = null)
  {
    return $this->query()->paginate($params, $relation, $perPage);
  }
}
