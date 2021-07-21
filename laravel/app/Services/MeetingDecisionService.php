<?php

namespace App\Services;

use App\Contracts\Queries\MeetingDecisionQueryInterface as Query;
use App\Contracts\Repositories\MeetingDecisionRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\MeetingRecord;
use App\Models\Task;
use App\Services\Traits\WithRepositoryTrait;

class MeetingDecisionService extends Service
{
  use WithRepositoryTrait;

  /**
   * @var string
   */
  private $attachMethod = 'decisions';

  /**
   * @var TaskService
   */
  protected $taskService;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   * @param TaskService $taskService
   */

  public function __construct(
    Repository $repository,
    Query $query,
    TaskService $taskService
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->taskService = $taskService;
  }

  /**
   * @param int $id
   * @param array $loads
   * @return MeetingDecision
   */
  public function find(int $id, array $loads = []): MeetingDecision
  {
    return $this->repository()->find($id, $loads);
  }

  /**
   * @param array $params
   * @param MeetingRecord $meetingRecord
   * @return MeetingDecision
   */
  public function store(array $params, MeetingRecord $meetingRecord): MeetingDecision
  {
    $meetingDecision = $this->repository()->attach($params, $meetingRecord, $this->attachMethod);
    if (isset($params['tasks'])) {
      return $this->saveTasksByDecision($params, $meetingDecision);
    }
    return $meetingDecision;
  }

  /**
   * @param array $params
   * @param MeetingRecord $meetingRecord
   * @param int $id
   * @return MeetingDecision
   */
  public function update(array $params, MeetingRecord $meetingRecord, int $id): MeetingDecision
  {
    $meetingDecision = $this->repository()->attach($params, $meetingRecord, $this->attachMethod, $id);
    if (isset($params['tasks'])) {
      return $this->saveTasksByDecision($params, $meetingDecision);
    }
    return $meetingDecision;
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function delete(int $id)
  {
    $deletedDecision = $this->repository()->delete($id);
    if (!!$deletedDecision->tasks->count()) {
      $deletedDecision->tasks->each(function($task) {
        $this->taskService->delete($task->id);
      });
    }
    return $deletedDecision;
  }

  /**
   * @param array $params
   * @param MeetingRecord $meetingRecord
   * @param int $id
   * @return MeetingDecision
   */
  public function updateOrDelete(array $params, MeetingRecord $meetingRecord, int $id): MeetingDecision
  {
    if ($params['flag'] === ProcessFlag::value('delete')) {
      return $this->delete($params['id']);
    }
    return $this->update($params, $meetingRecord, $id);
  }

  /**
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @return MeetingDecision
   */
  public function saveTasksByDecision(array $params, MeetingDecision $meetingDecision): MeetingDecision
  {
    foreach($params['tasks'] as $taskParams) {
      $tasks[] = $this->saveTaskByDecision($taskParams, $meetingDecision);
    }
    $meetingDecision->load($this->query()->relation());
    return $meetingDecision;
  }

  /**
   * @param array $taskParams
   * @param MeetingDecision $meetingDecision
   * @return Task
   */
  private function saveTaskByDecision(array $taskParams, MeetingDecision $meetingDecision): Task
  {
    if (empty($taskParams['id'] ?? '')) {
      return $this->taskService->attach($taskParams, $meetingDecision);
    } elseif (empty($taskParams['flag'] ?? '')) {
      return $this->taskService->find($taskParams['id']);
    } elseif($taskParams['flag'] === ProcessFlag::value('delete')) {
      return $this->taskService->delete($taskParams['id']);
    }
    return $this->taskService->attach($taskParams, $meetingDecision, $taskParams['id']);
  }
}
