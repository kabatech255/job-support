<?php

namespace App\Services;

use App\Contracts\Repositories\TaskRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\Task as Task;
use App\Services\Traits\WithRepositoryTrait;
use App\Contracts\Queries\TaskQueryInterface as Query;

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
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
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
   * @param MeetingDecision $meetingDecision
   * @return Task
   */
  public function store(array $params, MeetingDecision $meetingDecision): Task
  {
    return $this->repository()->attach($params, $meetingDecision, $this->attachMethod);
  }

  /**
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @param $id
   * @return Task
   */
  public function update(array $params, MeetingDecision $meetingDecision, $id): Task
  {
    return $this->repository()->attach($params, $meetingDecision, $this->attachMethod, $id);
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
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @param int $id
   * @return Task
   */
  public function updateOrDelete(array $params, MeetingDecision $meetingDecision, int $id): Task
  {
    if ($params['flag'] === ProcessFlag::value('delete')) {
      return $this->delete($id);
    }
    return $this->update($params, $meetingDecision, $id);
  }
}
