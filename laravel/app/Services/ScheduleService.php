<?php

namespace App\Services;

use App\Contracts\Queries\ScheduleQueryInterface as Query;
use App\Contracts\Repositories\ScheduleRepositoryInterface as Repository;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use App\Models\Schedule;
use App\Models\User;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ScheduleService extends Service
{
  use WithRepositoryTrait;

  /**
   * @var UserRepository
   */
  private $userRepository;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query,
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

  public function index(array $params, ?array $relation = null)
  {
    return $this->query()->daily($params, $relation ?? $this->query()->relation());
  }

  /**
   * @param $ownerId
   * @return Schedule[]
   */
  public function findByOwner($ownerId): array
  {
    $owner = $this->userRepository->find($ownerId);
    $schedules = $owner->sharedSchedules->load(['sharedMembers', 'scheduledBy']);
    return $schedules->all();
  }

  /**
   * @param array $params
   * @return Schedule
   */
  public function store(array $params): Schedule
  {
    $params = $this->addMe($params);
    return $this->repository()->saveWithMembers($params, 'sharedMembers');
  }

  /**
   * @param $id
   * @param array $loads
   * @return Schedule
   */
  public function find($id, ?array $loads = null): Schedule
  {
    return $this->repository()->find($id, $loads ?? $this->query()->relation());
  }

  /**
   * @param array $params
   * @param $id
   * @return Schedule
   */
  public function update(array $params, $id): Schedule
  {
    return $this->repository()->saveWithMembers($params, 'sharedMembers', $id);
  }

  /**
   * @param $id
   * @return Schedule
   */
  public function delete($id): Schedule
  {
    return $this->repository()->delete($id);
  }

  /**
   * @param array $params
   * @return array
   */
  private function addMe(array $params)
  {
    $params['sharedMembers'][Auth::user()->id] = [
      'is_editable' => 1,
      'shared_by' => Auth::user()->id,
    ];
    return $params;
  }
}
