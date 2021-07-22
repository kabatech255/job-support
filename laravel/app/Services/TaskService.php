<?php

namespace App\Services;

use App\Contracts\Repositories\TaskRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\Task as Task;
use App\Services\Traits\WithRepositoryTrait;
use App\Contracts\Queries\TaskQueryInterface as Query;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TaskService extends Service
{
  use WithRepositoryTrait;

  private $attachMethod = 'tasks';

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
   * @param array|null $relation
   * @return Task[]
   */
  public function index(array $params, ?array $relation = null): array
  {
    return $this->query()->all($params, $relation);
  }

  /**
   * @param int $ownerId
   * @return LengthAwarePaginator
   */
  public function findByOwner(array $params, int $ownerId, $perPage): LengthAwarePaginator
  {
    $params['owner_id'] = $ownerId;
    return $this->query()->paginate($params, $perPage);
  }

  /**
   * @param int $id
   * @param array $loads
   * @return Task
   */
  public function find(int $id, array $loads = []): Task
  {
    return $this->repository()->find($id, $loads);
  }


  /**
   * @param array $params
   * @return Task
   */
  public function store(array $params): Task
  {
    return $this->repository()->save($params);
  }

  /**
   * @param array $params
   * @param $id
   * @return Task
   */
  public function update(array $params, $id): Task
  {
    return $this->repository()->save($params, $id);
  }

  /**
   * @param $id
   * @return Task
   */
  public function delete($id): Task
  {
    return $this->repository()->delete($id);
  }

  /**
   * @param array $queryParams
   * @param array $params
   * @param int $perPage
   * @return LengthAwarePaginator
   */
  public function deleteAll(array $queryParams, array $params, int $perPage): LengthAwarePaginator
  {
    $tasks = $this->repository()->detach($params);
    return $this->findByOwner($queryParams, Auth::user()->id, $perPage);
  }

  /**
   * @param $params
   * @param $meetingDecision
   * @param $id
   * @return Task
   */
  public function attach($params, $meetingDecision, $id = null): Task
  {
    return $this->repository()->attach($params, $meetingDecision, $this->attachMethod, $id);
  }
}
