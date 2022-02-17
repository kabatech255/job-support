<?php

namespace App\Services;

use App\Contracts\Repositories\TaskRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\Task as Task;
use App\Models\User;
use App\Services\Supports\WithRepositoryTrait;
use App\Contracts\Queries\TaskQueryInterface as Query;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;

class TaskService extends Service
{
  use WithRepositoryTrait;

  private $attachMethod = 'tasks';

  /**
   * @var UserRepository
   */
  private $userRepository;

  /**
   * UserRepository constructor.
   * @param Repository $repository
   * @param Query $query
   * @param UserRepository $userRepository
   */
  public function __construct(
    Repository $repository,
    Query $query,
    UserRepository $userRepository
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->userRepository = $userRepository;
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
   * @return array
   */
  public function findByOwner(array $params, $perPage, $ownerId = null): array
  {
    $params['owner_id'] = !$ownerId ? Auth::user()->id : $ownerId;
    $pager = $this->query()->paginate($params, $perPage);
    if (!!$pager) {
      $data = json_decode(json_encode($pager), true);
      $data['query_params'] = $params;
      return $data;
    }
    return json_decode(json_encode($pager), true);
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
   * @return array
   */
  public function deleteAll(array $queryParams, array $params, int $perPage): array
  {
    $tasks = $this->repository()->detach($params);
    return $this->findByOwner($queryParams, $perPage);
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

  /**
   * @param $target
   * @return array
   */
  public function findBusyByOwner($target = null): array
  {
    if ($target === null) {
      $target = Auth::user()->id;
    }
    $user = $this->userRepository->find($target);
    return $this->filterBusy($user->load(['tasks.progress'])->tasks);
  }

  /**
   * @param Collection $tasks
   * @return array
   */
  public function filterBusy(Collection $tasks): array
  {
    $filtered = $tasks->filter(function ($task) {
      return $task->is_busy;
    });
    if (!!$filtered->count()) {
      $grouped = $filtered->sortBy('time_limit')->groupBy('status')->toArray();
      return collect(['over', 'warning'])->combine([$grouped['over'] ?? [], $grouped['warning'] ?? []])->all();
    }
    return $this->emptyBusyData();
  }

  /**
   * @return array
   */
  private function emptyBusyData(): array
  {
    return collect(['over', 'warning'])->combine([[], []])->all();
  }
}
